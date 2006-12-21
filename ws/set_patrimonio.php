<? 
 /* 
 Copyright 2000, 2001, 2002, 2003, 2004, 2005 Dataprev - Empresa de Tecnologia e Informa��es da Previd�ncia Social, Brasil

 Este arquivo � parte do programa CACIC - Configurador Autom�tico e Coletor de Informa��es Computacionais

 O CACIC � um software livre; voc� pode redistribui-lo e/ou modifica-lo dentro dos termos da Licen�a P�blica Geral GNU como 
 publicada pela Funda��o do Software Livre (FSF); na vers�o 2 da Licen�a, ou (na sua opni�o) qualquer vers�o.

 Este programa � distribuido na esperan�a que possa ser  util, mas SEM NENHUMA GARANTIA; sem uma garantia implicita de ADEQUA��O a qualquer
 MERCADO ou APLICA��O EM PARTICULAR. Veja a Licen�a P�blica Geral GNU para maiores detalhes.

 Voc� deve ter recebido uma c�pia da Licen�a P�blica Geral GNU, sob o t�tulo "LICENCA.txt", junto com este programa, se n�o, escreva para a Funda��o do Software
 Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

// Defini��o do n�vel de compress�o (Default=m�ximo)
//$v_compress_level = '9';
$v_compress_level = '0';
 
require_once('../include/library.php');

// Essas vari�veis conter�o os indicadores de criptografia e compacta��o
$v_cs_cipher	= (trim($_POST['cs_cipher'])   <> ''?trim($_POST['cs_cipher'])   : '4');
$v_cs_compress	= (trim($_POST['cs_compress']) <> ''?trim($_POST['cs_compress']) : '4');

autentica_agente($key,$iv,$v_cs_cipher,$v_cs_compress);


$v_dados_rede = getDadosRede();

// Se o envio de informa��es foi feito com dados criptografados... (Vers�es 2.0.2.5+)
$te_node_address 	= DeCrypt($key,$iv,$_POST['te_node_address']	,$v_cs_cipher,$v_cs_compress); 
$id_so           	= DeCrypt($key,$iv,$_POST['id_so']				,$v_cs_cipher,$v_cs_compress); 

//Para implementa��o futura ap�s altera��o do agente, para que ele tamb�m envie os dados abaixo
$te_nome_computador = DeCrypt($key,$iv,$_POST['te_nome_computador']	,$v_cs_cipher,$v_cs_compress); 
$te_ip              = DeCrypt($key,$iv,$_POST['te_ip']				,$v_cs_cipher,$v_cs_compress); 
$te_nome_host       = DeCrypt($key,$iv,$_POST['te_nome_host']		,$v_cs_cipher,$v_cs_compress); 
$id_ip_rede         = DeCrypt($key,$iv,$_POST['id_ip_rede']			,$v_cs_cipher,$v_cs_compress);
$te_workgroup       = DeCrypt($key,$iv,$_POST['te_workgroup']		,$v_cs_cipher,$v_cs_compress);

/* Todas as vezes em que � feita a recupera��o das configura��es por um agente, � inclu�do 
 o computador deste agente no BD, caso ainda n�o esteja inserido. */
if ($te_node_address || $id_so || $te_nome_computador || $te_ip || $te_workgroup || $id_ip_rede <> '')
	{ 
	inclui_computador_caso_nao_exista(	$te_node_address, 
									  	$id_so, 
									  	$id_ip_rede, 
									  	$te_ip, 
									  	$te_nome_computador, 
									  	$te_workgroup);																				
	}


// Aten��o: n�o use o count (*) - Com espa�o entre o count e o (*)				
$query = "SELECT COUNT(*) 
		  FROM patrimonio 
		  WHERE te_node_address = '" . $te_node_address . "'
		  AND id_so = '" . $id_so . "'";
conecta_bd_cacic();
$result = mysql_query($query);
if (mysql_num_rows($result) > 0) 
	{  // Atualiza��o das informa��es de patrim�nio (e n�o inclus�o). 

   // Agora, verifica se os administradores dever�o ser notificados da altera��o nas informa��es de patrim�nio.
  	if (trim($destinatarios = get_valor_campo('configuracoes_locais', 'te_notificar_mudanca_patrim')) != '') 
		{
		$query 	= "	SELECT 	te_etiqueta,nm_campo_tab_patrimonio 
				 	FROM 	patrimonio_config_interface
					WHERE	id_local = ".$v_dados_rede['id_local'];
		$result = mysql_query($query);
		$tripa_nomes_campos = '';
		while($row=mysql_fetch_array($result))
			{
			$tripa_nomes_campos .= $row['nm_campo_tab_patrimonio'].'#'.$row['te_etiqueta'].'#';
			}

		$tripa_nomes_campos = substr($tripa_nomes_campos,0,strlen($tripa_nomes_campos)-1);	
		$array_nomes_campos = explode('#',$tripa_nomes_campos);

		// Monto um array com as UO N�vel 1
		$query 	= "SELECT 	id_unid_organizacional_nivel1, nm_unid_organizacional_nivel1
				   FROM 	unid_organizacional_nivel1";
		$result = mysql_query($query);
		$tripa_nomes_UON1 = '';
		while($row=mysql_fetch_array($result))
			{
			$tripa_nomes_UON1 .= $row['id_unid_organizacional_nivel1'].'#'.$row['nm_unid_organizacional_nivel1'].'#';
			}

		$tripa_nomes_UON1 = substr($tripa_nomes_UON1,0,strlen($tripa_nomes_UON1)-1);	
		$array_nomes_UON1 = explode('#',$tripa_nomes_UON1);

		// Monto um array com as UO N�vel 2 relacionadas �s suas UO N�vel 1
		$query 	= "SELECT 	a.id_unid_organizacional_nivel2, 
							a.nm_unid_organizacional_nivel2
				   FROM 	unid_organizacional_nivel2 a, 
				   			unid_organizacional_nivel1 b,
							locais c
				   WHERE	a.id_unid_organizacional_nivel1 = b.id_unid_organizacional_nivel1 AND
				            b.id_local = c.id_local AND
							c.id_local = ".$v_dados_rede['id_local'];
		$result = mysql_query($query);
		$tripa_nomes_UON2 = '';
		while($row=mysql_fetch_array($result))
			{
			$tripa_nomes_UON2 .= $row['id_unid_organizacional_nivel2'].'#'.$row['nm_unid_organizacional_nivel2'].'#';
			}

		$tripa_nomes_UON2 = substr($tripa_nomes_UON2,0,strlen($tripa_nomes_UON2)-1);	
		$array_nomes_UON2 = explode('#',$tripa_nomes_UON2);


		$query = "SELECT * 
				  FROM patrimonio
				  WHERE te_node_address = '" . $te_node_address . "'
						AND id_so = '" . $id_so . "'";

		$result = mysql_query($query);

		// Recupero as �ltimas informa��es de patrim�nio para montar o e-mail.
		$campos = mysql_fetch_array($result);

		// Varre todos os campos e verifica quais foram os que sofreram altera��es.
		$cont_aux = 0;
		$campos_alterados = '';

		for ($i=0; $i < mysql_num_fields($result); $i++) 
			{
			$nome_campo_tabela = mysql_field_name($result, $i); 											
			$tam_campo_tabela = mysql_field_len($result, $i);
			$posicao_array_nomes_campos = array_search($nome_campo_tabela, $array_nomes_campos);
			$nome_campo_tela = $array_nomes_campos[$posicao_array_nomes_campos + 1];
			if (($campos["$nome_campo_tabela"] != substr(DeCrypt($key,$iv,$_POST[$nome_campo_tabela],$v_cs_cipher,$v_cs_compress), 0, $tam_campo_tabela)) && ($nome_campo_tabela != 'dt_hr_alteracao' && $nome_campo_tabela != 'id_so' && $nome_campo_tabela != 'te_node_address')) 
				{
				if ($nome_campo_tabela != 'id_unid_organizacional_nivel1' && $nome_campo_tabela != 'id_unid_organizacional_nivel2')
					{
					$valor_anterior = 	$campos["$nome_campo_tabela"];
					$valor_atual	=	DeCrypt($key,$iv,$_POST["$nome_campo_tabela"],$v_cs_cipher,$v_cs_compress);
					}									
				else
					{
					if ($nome_campo_tabela == 'id_unid_organizacional_nivel1')
						{
						$posicao_array_nomes_UON1 = array_search($campos["$nome_campo_tabela"], $array_nomes_UON1);
						$valor_anterior = $array_nomes_UON1[$posicao_array_nomes_UON1 + 1];
						$posicao_array_nomes_UON1 = array_search(DeCrypt($key,$iv,$_POST["$nome_campo_tabela"],$v_cs_cipher,$v_cs_compress), $array_nomes_UON1);
						$valor_atual = $array_nomes_UON1[$posicao_array_nomes_UON1 + 1];
						}
					else
						{
						$posicao_array_nomes_UON2 = array_search($campos["$nome_campo_tabela"], $array_nomes_UON2);
						$valor_anterior = $array_nomes_UON2[$posicao_array_nomes_UON2 + 1];
						$posicao_array_nomes_UON2 = array_search(DeCrypt($key,$iv,$_POST["$nome_campo_tabela"],$v_cs_cipher,$v_cs_compress), $array_nomes_UON2);
						$valor_atual = $array_nomes_UON2[$posicao_array_nomes_UON2 + 1];
						}
					}
				$campos_alterados =  $campos_alterados . $nome_campo_tela .  ":\n" . str_repeat('-', strlen($nome_campo_tela)) .  "\nValor Anterior.: " . $valor_anterior . "\nNovo Valor.....: " . $valor_atual . "\n\n";
				$cont_aux++;
				}
			}

		$query = "SELECT te_nome_computador, id_ip_rede, te_ip 
			  FROM computadores 
			  WHERE te_node_address = '" . $te_node_address . "'
			  AND id_so = '" . $id_so . "'";
		$result = mysql_query($query);

    	if ($cont_aux > 0) 
			{ 
    		$corpo_mail = "
Prezado administrador,\n
Foi identificada uma altera��o nas informa��es de patrim�nio do seguinte computador:\n
Nome...........: ". mysql_result( $result, 0, "te_nome_computador" ) ."
Endere�o TCP/IP: ". mysql_result( $result, 0, "te_ip" ) . "
Rede...........: ". mysql_result( $result, 0, "id_ip_rede" ) ."\n\n
As informa��es que sofreram altera��es est�o relacionadas abaixo:\n\n" .
$campos_alterados ."\n\n
Para visualizar mais informa��es sobre esse computador, acesse o endere�o
http://" . $_SERVER['SERVER_ADDR'] . "/cacic2/relatorios/computador/computador.php?id_so=" . $id_so . "&te_node_address=" . $te_node_address . "\n
______________________________________________
CACIC - " . date('d/m/Y H:i') . "h
Desenvolvido pelo Escrit�rio da Dataprev do ES";

			// Manda mail para os administradores.
			mail("$destinatarios", "Alteracao de Patrimonio Detectada", "$corpo_mail", "From: cacic@{$_SERVER['SERVER_NAME']}");
			}
		}
	}


// Inclui as informa��es no hist�rico.
$query = "INSERT INTO patrimonio 
										(te_node_address,
											id_so,
											dt_hr_alteracao,
											id_unid_organizacional_nivel1,
											id_unid_organizacional_nivel2,
											te_localizacao_complementar,
											te_info_patrimonio1,
											te_info_patrimonio2,
											te_info_patrimonio3,
											te_info_patrimonio4,
											te_info_patrimonio5,
											te_info_patrimonio6)
		 VALUES ('" . $te_node_address . "', 
		         '" . $id_so . "',
											NOW(),
											'" . DeCrypt($key,$iv,$_POST['id_unid_organizacional_nivel1']	,$v_cs_cipher,$v_cs_compress) . "', 
											'" . DeCrypt($key,$iv,$_POST['id_unid_organizacional_nivel2']	,$v_cs_cipher,$v_cs_compress) . "', 
											'" . DeCrypt($key,$iv,$_POST['te_localizacao_complementar']		,$v_cs_cipher,$v_cs_compress) . "', 
											'" . DeCrypt($key,$iv,$_POST['te_info_patrimonio1']				,$v_cs_cipher,$v_cs_compress) . "', 
											'" . DeCrypt($key,$iv,$_POST['te_info_patrimonio2']				,$v_cs_cipher,$v_cs_compress) . "', 
											'" . DeCrypt($key,$iv,$_POST['te_info_patrimonio3']				,$v_cs_cipher,$v_cs_compress) . "', 
											'" . DeCrypt($key,$iv,$_POST['te_info_patrimonio4']				,$v_cs_cipher,$v_cs_compress) . "',
											'" . DeCrypt($key,$iv,$_POST['te_info_patrimonio5']				,$v_cs_cipher,$v_cs_compress) . "',
											'" . DeCrypt($key,$iv,$_POST['te_info_patrimonio6']				,$v_cs_cipher,$v_cs_compress) . "')";
$result = mysql_query($query);
echo '<?xml version="1.0" encoding="iso-8859-1" ?><STATUS>OK</STATUS>';
?>
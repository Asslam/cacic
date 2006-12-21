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

$te_node_address 	= DeCrypt($key,$iv,$_POST['te_node_address']	,$v_cs_cipher, $v_cs_compress); 
$id_so           	= DeCrypt($key,$iv,$_POST['id_so']				,$v_cs_cipher, $v_cs_compress); 
$id_ip_rede     	= DeCrypt($key,$iv,$_POST['id_ip_rede']			,$v_cs_cipher, $v_cs_compress);
$te_ip 				= DeCrypt($key,$iv,$_POST['te_ip']				,$v_cs_cipher, $v_cs_compress); 
$te_nome_computador	= DeCrypt($key,$iv,$_POST['te_nome_computador']	,$v_cs_cipher, $v_cs_compress); 
$te_workgroup 		= DeCrypt($key,$iv,$_POST['te_workgroup']		,$v_cs_cipher, $v_cs_compress); 

/* Todas as vezes em que � feita a recupera��o das configura��es por um agente, � inclu�do 
 o computador deste agente no BD, caso ainda n�o esteja inserido. */
if ($te_node_address || $id_so || $te_nome_computador || $te_ip || $te_workgroup || $id_ip_rede  <> '')
	{ 
	inclui_computador_caso_nao_exista(	$te_node_address, 
										$id_so, 
										$id_ip_rede, 
										$te_ip, 
										$te_nome_computador, 
										$te_workgroup);										
	}

conecta_bd_cacic();

/* A consulta abaixo � usada para identificar se � um atualiza��o das informa��es de hardware 
   ou uma inclus�o. Apenas s�o notificadas as altera��es de hardware.
 Aten��o: n�o use o count (*) - Com espa�o entre o count e o (*)				 */
$query = "SELECT COUNT(*) 
		  FROM historico_hardware 
		  WHERE te_node_address = '" . $te_node_address . "'
		  AND id_so = '" . $id_so . "'";
					
$result = mysql_query($query);
if (mysql_num_rows($result) > 0) {  // Atualiza��o das informa��es de hardware (e n�o inclus�o). 

   // Agora, verifica se os administradores dever�o ser notificados da altera��o na configura��o de hardware.
  	if (trim($destinatarios = get_valor_campo('configuracoes_locais', 'te_notificar_mudanca_hardware')) != '') {

       /* Consulto todos os hardwares que foram selecionados para notificacao. Isso � setado pelo administrador na p�gina de 'Configura��es Gerais'.*/ 
		  	  	$query = "SELECT 	nm_campo_tab_hardware, te_desc_hardware
				          FROM 		descricao_hardware 
						  WHERE 	cs_notificacao_ativada = '1'";
  						$result_hardwares_selecionados = mysql_query($query) or die('Ocorreu um erro durante a consulta � tabela descricao_hardware.');

		  				/* Agora seleciono as colunas que ser�o consultadas na tabela 'computadores', para verificar as 
   								configura��es de hardware atuais. 
											Aproveito esse mesmo loop para criar um array que tem nm_campo_tab_hardware => te_desc_hardware.
									*/ 
   					while($campos_hardwares_selecionados = mysql_fetch_array($result_hardwares_selecionados)) {
 				 		   $sql_aux = $sql_aux . $campos_hardwares_selecionados['nm_campo_tab_hardware'] . ','; 
           $descricao_campo[$campos_hardwares_selecionados[nm_campo_tab_hardware]] = $campos_hardwares_selecionados[te_desc_hardware];
  						}
								$sql_aux = substr($sql_aux, 0, strlen($sql_aux)-1);	 // Tiro a �ltima v�rgula

		  				/* Agora identifico quais s�o as configura��es de hardware atualmente armazenadas no BD. */ 
     				$query = 'SELECT 	' . $sql_aux . " 
							  FROM 		computadores
							  WHERE 	te_node_address = '" . $te_node_address . "' AnD 
							  			id_so = '" . $id_so . "'";
     				$result = mysql_query($query);
     		  $campos = mysql_fetch_array($result);

				     // Varre todos os campos e verifica quais foram os que sofreram altera��es, para montar o e-mail.
     				$cont_aux = 0;
     				$campos_alterados = '';
				     for ($i=0; $i < mysql_num_fields($result); $i++) {
						       	$nome_campo = mysql_field_name($result, $i); 
       							$tam_campo = mysql_field_len($result, $i); 
														if (($campos[$nome_campo] != substr(DeCrypt($key,$iv,$_POST[$nome_campo],$v_cs_cipher,$v_cs_compress), 0, $tam_campo)) && ($nome_campo != 'dt_hr_alteracao') && ($nome_campo != 'te_cpu_freq') ) {
														     $cabecalho_campo = $descricao_campo[$nome_campo] . ' (' . $nome_campo . ')';
         							   $campos_alterados =  $campos_alterados . $cabecalho_campo . "\n" . str_repeat('-', strlen($cabecalho_campo)) .  "\nValor Anterior.: " . $campos[$nome_campo] . "\nNovo Valor.....: " . DeCrypt($key,$iv,$_POST[$nome_campo],$v_cs_cipher,$v_cs_compress) . "\n\n";
						             $cont_aux++;
        						}
				     }
				
				     //Recupero informa��es sobre o computador, para montar o cabe�alho do e-mail.
        	$query = "SELECT 	te_nome_computador, id_ip_rede, te_ip 
     		  		  FROM 		computadores 
    			      WHERE 	te_node_address = '" . $te_node_address . "' AND 
					  			id_so = '" . $id_so . "'";
        	$result = mysql_query($query);

         if ($cont_aux > 0) { 
    		      $corpo_mail = "Prezado administrador,\n		  
Foi identificada uma altera��o na configura��o de hardware do seguinte computador:\n
Nome...........: ". mysql_result( $result, 0, "te_nome_computador" ) ." 
Endere�o TCP/IP: ". mysql_result( $result, 0, "te_ip" ) . "
Rede...........: ". mysql_result( $result, 0, "id_ip_rede" ) ."\n
As configura��es que sofreram altera��es est�o relacionadas abaixo:\n\n" . 
$campos_alterados .
"\n\nPara visualizar mais informa��es sobre esse computador, acesse o endere�o\nhttp://" .
$_SERVER['SERVER_ADDR'] . '/cacic2/relatorios/computador/computador.php?te_node_address=' . $te_node_address . '&id_so=' . $id_so .
"\n\n________________________________________________
CACIC - " . date('d/m/Y H:i') . 'h
Desenvolvido pelo Escrit�rio da Dataprev do ES';

							// Manda mail para os administradores.
								mail("$destinatarios", "Alteracao de Hardware Detectada", "$corpo_mail", "From: cacic@{$_SERVER['SERVER_NAME']}");

								//echo $corpo_mail;
								//Simula��o de agente em browser.  � necess�rio inibir a linha autentica_agente() no in�cio do script.
				}
	}
}






// Inclui as informa��es do novo hardware no hist�rico e atualiza as informa��es do computador.
$query = "INSERT INTO historico_hardware 
										(te_node_address,
											id_so,
											dt_hr_alteracao,
											te_placa_rede_desc,
											te_mem_ram_desc,
											qt_mem_ram,
											te_cpu_serial,
											te_cpu_fabricante,
											te_cpu_desc,
											te_cpu_freq,
											te_bios_desc,
											te_bios_data,
											te_bios_fabricante,
											te_placa_mae_desc,
											te_placa_mae_fabricante,
											qt_placa_video_mem,
											qt_placa_video_cores,
											te_placa_video_desc,
											te_placa_video_resolucao,
											te_placa_som_desc,
											te_cdrom_desc,
											te_teclado_desc,
											te_mouse_desc,
											te_modem_desc)											
		 VALUES ('" . $te_node_address . "', 
		         '" . $id_so . "',
											NOW(),
											'" . DeCrypt($key,$iv,$_POST['te_placa_rede_desc']		,$v_cs_cipher,$v_cs_compress) . "', 
											'" . DeCrypt($key,$iv,$_POST['te_mem_ram_desc']			,$v_cs_cipher,$v_cs_compress) . "', 
											'" . DeCrypt($key,$iv,$_POST['qt_mem_ram']				,$v_cs_cipher,$v_cs_compress) . "', 
											'" . DeCrypt($key,$iv,$_POST['te_cpu_serial']			,$v_cs_cipher,$v_cs_compress) . "', 
											'" . DeCrypt($key,$iv,$_POST['te_cpu_fabricante']		,$v_cs_cipher,$v_cs_compress) . "', 
											'" . DeCrypt($key,$iv,$_POST['te_cpu_desc']				,$v_cs_cipher,$v_cs_compress) . "', 
											'" . DeCrypt($key,$iv,$_POST['te_cpu_freq']				,$v_cs_cipher,$v_cs_compress) . "',
											'" . DeCrypt($key,$iv,$_POST['te_bios_desc']			,$v_cs_cipher,$v_cs_compress) . "',
											'" . DeCrypt($key,$iv,$_POST['te_bios_data']			,$v_cs_cipher,$v_cs_compress) . "',
											'" . DeCrypt($key,$iv,$_POST['te_bios_fabricante']		,$v_cs_cipher,$v_cs_compress) . "',
											'" . DeCrypt($key,$iv,$_POST['te_placa_mae_desc']		,$v_cs_cipher,$v_cs_compress) . "',
											'" . DeCrypt($key,$iv,$_POST['te_placa_mae_fabricante']	,$v_cs_cipher,$v_cs_compress) . "',
											'" . DeCrypt($key,$iv,$_POST['qt_placa_video_mem']		,$v_cs_cipher,$v_cs_compress) . "',
											'" . DeCrypt($key,$iv,$_POST['qt_placa_video_cores']	,$v_cs_cipher,$v_cs_compress) . "',
											'" . DeCrypt($key,$iv,$_POST['te_placa_video_desc']		,$v_cs_cipher,$v_cs_compress) . "',
											'" . DeCrypt($key,$iv,$_POST['te_placa_video_resolucao'],$v_cs_cipher,$v_cs_compress) . "',
											'" . DeCrypt($key,$iv,$_POST['te_placa_som_desc']		,$v_cs_cipher,$v_cs_compress) . "',
											'" . DeCrypt($key,$iv,$_POST['te_cdrom_desc']			,$v_cs_cipher,$v_cs_compress) . "',
											'" . DeCrypt($key,$iv,$_POST['te_teclado_desc']			,$v_cs_cipher,$v_cs_compress) . "',
											'" . DeCrypt($key,$iv,$_POST['te_mouse_desc']			,$v_cs_cipher,$v_cs_compress) . "',
											'" . DeCrypt($key,$iv,$_POST['te_modem_desc']			,$v_cs_cipher,$v_cs_compress) . "')";																						
$result = mysql_query($query);

// Lembre-se de que o computador j� existe. Ele � criado durante a obten��o das configura��es, no arquivo get_config.php.
$query = "UPDATE computadores 
										SET	te_placa_rede_desc       			 = '" . DeCrypt($key,$iv,$_POST['te_placa_rede_desc']		,$v_cs_cipher,$v_cs_compress) . "', 
														te_mem_ram_desc          = '" . DeCrypt($key,$iv,$_POST['te_mem_ram_desc']			,$v_cs_cipher,$v_cs_compress) . "', 
														qt_mem_ram               = '" . DeCrypt($key,$iv,$_POST['qt_mem_ram']				,$v_cs_cipher,$v_cs_compress) . "',
														te_cpu_serial            = '" . DeCrypt($key,$iv,$_POST['te_cpu_serial']			,$v_cs_cipher,$v_cs_compress) . "',
														te_cpu_fabricante        = '" . DeCrypt($key,$iv,$_POST['te_cpu_fabricante']		,$v_cs_cipher,$v_cs_compress) . "',
														te_cpu_desc              = '" . DeCrypt($key,$iv,$_POST['te_cpu_desc']				,$v_cs_cipher,$v_cs_compress) . "',
														te_cpu_freq              = '" . DeCrypt($key,$iv,$_POST['te_cpu_freq']				,$v_cs_cipher,$v_cs_compress) . "',
														te_bios_desc             = '" . DeCrypt($key,$iv,$_POST['te_bios_desc']				,$v_cs_cipher,$v_cs_compress) . "',
														te_bios_data             = '" . DeCrypt($key,$iv,$_POST['te_bios_data']				,$v_cs_cipher,$v_cs_compress) . "',
														te_bios_fabricante       = '" . DeCrypt($key,$iv,$_POST['te_bios_fabricante']		,$v_cs_cipher,$v_cs_compress) . "',
														te_placa_mae_desc        = '" . DeCrypt($key,$iv,$_POST['te_placa_mae_desc']		,$v_cs_cipher,$v_cs_compress) . "',
														te_placa_mae_fabricante  = '" . DeCrypt($key,$iv,$_POST['te_placa_mae_fabricante']	,$v_cs_cipher,$v_cs_compress) . "',
														qt_placa_video_mem       = '" . DeCrypt($key,$iv,$_POST['qt_placa_video_mem']		,$v_cs_cipher,$v_cs_compress) . "',
														qt_placa_video_cores     = '" . DeCrypt($key,$iv,$_POST['qt_placa_video_cores']		,$v_cs_cipher,$v_cs_compress) . "',
														te_placa_video_desc      = '" . DeCrypt($key,$iv,$_POST['te_placa_video_desc']		,$v_cs_cipher,$v_cs_compress) . "',
														te_placa_video_resolucao = '" . DeCrypt($key,$iv,$_POST['te_placa_video_resolucao']	,$v_cs_cipher,$v_cs_compress) . "',
														te_placa_som_desc        = '" . DeCrypt($key,$iv,$_POST['te_placa_som_desc']		,$v_cs_cipher,$v_cs_compress) . "',
														te_cdrom_desc            = '" . DeCrypt($key,$iv,$_POST['te_cdrom_desc']			,$v_cs_cipher,$v_cs_compress) . "',
														te_teclado_desc          = '" . DeCrypt($key,$iv,$_POST['te_teclado_desc']			,$v_cs_cipher,$v_cs_compress) . "',
														te_mouse_desc            = '" . DeCrypt($key,$iv,$_POST['te_mouse_desc']			,$v_cs_cipher,$v_cs_compress) . "',
														te_modem_desc            = '" . DeCrypt($key,$iv,$_POST['te_modem_desc']			,$v_cs_cipher,$v_cs_compress) . "' 
								WHERE te_node_address          = '" . $te_node_address . "' and
													 id_so                    = '" . $id_so . "'";
$result = mysql_query($query);


echo '<?xml version="1.0" encoding="iso-8859-1" ?><STATUS>OK</STATUS>';
?>
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
$te_node_address 			= DeCrypt($key,$iv,$_POST['te_node_address']		,$v_cs_cipher,$v_cs_compress); 
$id_so_new         			= DeCrypt($key,$iv,$_POST['id_so']					,$v_cs_cipher,$v_cs_compress); 
$te_so           			= DeCrypt($key,$iv,$_POST['te_so']					,$v_cs_cipher,$v_cs_compress); 
$id_ip_rede     			= DeCrypt($key,$iv,$_POST['id_ip_rede']				,$v_cs_cipher,$v_cs_compress);
$te_ip 						= DeCrypt($key,$iv,$_POST['te_ip']					,$v_cs_cipher,$v_cs_compress); 
$te_nome_computador			= DeCrypt($key,$iv,$_POST['te_nome_computador']		,$v_cs_cipher,$v_cs_compress); 
$te_workgroup 				= DeCrypt($key,$iv,$_POST['te_workgroup']			,$v_cs_cipher,$v_cs_compress); 

/* Todas as vezes em que � feita a recupera��o das configura��es por um agente, � inclu�do 
 o computador deste agente no BD, caso ainda n�o esteja inserido. */
if ($te_node_address <> '')
	{ 
	$id_so = inclui_computador_caso_nao_exista(	$te_node_address, 
												$id_so_new, 
												$te_so,
												$id_ip_rede, 
												$te_ip, 
												$te_nome_computador, 
												$te_workgroup);										
	conecta_bd_cacic();
	// Verifico se o computador em quest�o j� foi inserido anteriormente, e se n�o foi, insiro.
	$query = "SELECT count(*) as num_registros
			  FROM officescan
											WHERE te_node_address = '" . $te_node_address . "'
											AND id_so = '" . $id_so . "'";
	$result = mysql_query($query);
	if (mysql_result($result, 0, "num_registros") == 0) 
		{
						$query = "INSERT INTO officescan
																(te_node_address, id_so)
																VALUES ('" . $te_node_address . "', '" . $id_so . "'  )";
						$result = mysql_query($query);
		} 
	
	$query = "UPDATE officescan 
			  SET 	nu_versao_engine 	= '" . DeCrypt($key,$iv,$_POST['nu_versao_engine']	,$v_cs_cipher,$v_cs_compress) . "',
					nu_versao_pattern   = '" . DeCrypt($key,$iv,$_POST['nu_versao_pattern']	,$v_cs_cipher,$v_cs_compress) . "',
					dt_hr_coleta        = NOW(),
					dt_hr_instalacao    = '" . DeCrypt($key,$iv,$_POST['dt_hr_instalacao']	,$v_cs_cipher,$v_cs_compress) . "',
					te_servidor         = '" . DeCrypt($key,$iv,$_POST['te_servidor']		,$v_cs_cipher,$v_cs_compress) . "',
					in_ativo            = '" . DeCrypt($key,$iv,$_POST['in_ativo']			,$v_cs_cipher,$v_cs_compress) . "' 
			  WHERE te_node_address 	= '" . $te_node_address . "' and
					id_so           	= '" . $id_so . "'";
	$result = mysql_query($query);
	
	echo '<?xml version="1.0" encoding="iso-8859-1" ?><STATUS>OK</STATUS>';
	}
else
	echo '<?xml version="1.0" encoding="iso-8859-1" ?><STATUS>Chave (TE_NODE_ADDRESS + ID_SO) Inv�lida</STATUS>';	

?>
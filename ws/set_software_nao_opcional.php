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
// Essa coleta n�o � opcional, ou seja, o administrador n�o tem como desabilit�-la.
// Por isso foi necess�rio cri�-la de forma independente do script set_software.php.

// Defini��o do n�vel de compress�o (Default=m�ximo)
//$v_compress_level = '9';
$v_compress_level = '0';
 
require_once('../include/library.php');

// Essas vari�veis conter�o os indicadores de criptografia e compacta��o
$v_cs_cipher	= (trim($_POST['cs_cipher'])   <> ''?trim($_POST['cs_cipher'])   : '4');
$v_cs_compress	= (trim($_POST['cs_compress']) <> ''?trim($_POST['cs_compress']) : '4');

autentica_agente($key,$iv,$v_cs_cipher,$v_cs_compress);

$te_node_address = DeCrypt($key,$iv,$_POST['te_node_address']	,$v_cs_cipher,$v_cs_compress); 
$id_so           = DeCrypt($key,$iv,$_POST['id_so']				,$v_cs_cipher,$v_cs_compress); 

conecta_bd_cacic();

$query = "	UPDATE 	computadores 
			SET		te_versao_cacic   = '" . DeCrypt($key,$iv,$_POST['te_versao_cacic'],$v_cs_cipher,$v_cs_compress) . "'  
	  		WHERE 	te_node_address = '" . $te_node_address . "' and
					id_so           = '" . $id_so . "'";
$result = mysql_query($query);

echo '<?xml version="1.0" encoding="iso-8859-1" ?><STATUS>OK</STATUS>';

?>
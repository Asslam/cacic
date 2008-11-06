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

 Objetivo:
 ---------
 Esse script tem como objetivo enviar ao servidor de suporte remoto na esta��o(srcacic.exe) as configura��es (em XML) que s�o espec�ficas para a 
 esta��o/usu�rio em quest�o. S�o levados em considera��o a rede do agente, sistema operacional e Mac-Address.
 
 Retorno:
 1) <DOMINIOS>Dom�nios cadastrados no Gerente WEB. O dom�nio referente � subrede da esta��o ser� acrescido de "*".</DOMINIOS>
 2) <STATUS>Retornar� OK se a palavra chave informada "bater" com a chave armazenada previamente no BD</STATUS>
*/

require_once('../include/library.php');

// Defini��o do n�vel de compress�o (Default = 9 => m�ximo)
//$v_compress_level = 9;
$v_compress_level   = 0;  // Mantido em 0(zero) para desabilitar a Compress�o/Decompress�o 
						  // H� necessidade de testes para An�lise de Viabilidade T�cnica 

$retorno_xml_header = '<?xml version="1.0" encoding="iso-8859-1" ?>';
$retorno_xml_values = '';

// Essas vari�veis conter�o os indicadores de criptografia e compacta��o
$v_cs_cipher		= (trim($_POST['cs_cipher'])   <> ''?trim($_POST['cs_cipher'])   : '4');
$v_cs_compress		= (trim($_POST['cs_compress']) <> ''?trim($_POST['cs_compress']) : '4');

$v_cs_cipher		= '1';

$strPaddingKey  	= '';

/*	
LimpaTESTES();
GravaTESTES('Valores POST Recebidos:');
foreach($HTTP_POST_VARS as $i => $v) 
	GravaTESTES('Nome/Valor do POST_Request: "'.$i.'"/"'.$v.'"');

GravaTESTES('Valores GET Recebidos:');
foreach($HTTP_GET_VARS as $i => $v) 
	GravaTESTES('Nome/Valor do GET_Request: "'.$i.'"/"'.$v.'"');

GravaTESTES('');	
GravaTESTES('');	
*/

// Autentica��o da Esta��o Visitada
$te_node_address   	= DeCrypt($key,$iv,$_POST['te_node_address']	,$v_cs_cipher,$v_cs_compress,$strPaddingKey); 
$te_so             	= DeCrypt($key,$iv,$_POST['te_so']				,$v_cs_cipher,$v_cs_compress,$strPaddingKey); 
$te_palavra_chave  	= DeCrypt($key,$iv,$_POST['te_palavra_chave']	,$v_cs_cipher,$v_cs_compress,$strPaddingKey); 

// ATEN��O: Apenas retornar� um ARRAY contendo "id_so" e "te_so".
$arrSO = inclui_computador_caso_nao_exista(	$te_node_address, 
											'',
											$te_so,
											'', 
											'', 
											'',
											'');									

$arrComputadores 	= getValores('computadores', 'te_palavra_chave,id_ip_rede'   , 'te_node_address = "'.$te_node_address.'" and id_so = '.$arrSO['id_so']);;
$strTePalavraChave	= $arrComputadores['te_palavra_chave'];
$strIdIpRede		= $arrComputadores['id_ip_rede'];

/*
LimpaTESTES();
GravaTESTES('strTePalavraChave:'.$strTePalavraChave);
GravaTESTES('strIdIpRede:'.$strIdIpRede);
*/

// Valido a Palavra-Chave e monto a tripa com os nomes e ids dos dom�nios
if ($te_palavra_chave == $strTePalavraChave)
	{
	$arrRedes 		= getValores('redes','id_dominio','id_ip_rede = "'.$strIdIpRede.'"');
	$strIdDominio	= $arrRedes['id_dominio'];
	
	conecta_bd_cacic();	
	$query_SEL	= 'SELECT		id_dominio,
								nm_dominio  
				   FROM			dominios
				   WHERE		in_ativo = "S"
				   ORDER BY		nm_dominio';
	$result_SEL = mysql_query($query_SEL);
	
	$strTripaDominios = '';
	while ($row_SEL = mysql_fetch_array($result_SEL))
		$strTripaDominios .= $row_SEL['id_dominio'].';'.$row_SEL['nm_dominio'].($row_SEL['id_dominio']==$strIdDominio?'*':'').';';

	if ($strTripaDominios <> '')
		$retorno_xml_values = '<DOMINIOS>'.EnCrypt($key,$iv,$strTripaDominios  ,$v_cs_cipher,$v_cs_compress,$v_compress_level,$strPaddingKey).'</DOMINIOS>';
	}

if ($retorno_xml_values <> '')
	$retorno_xml_values = '<STATUS>'.EnCrypt($key,$iv,'OK',$v_cs_cipher,$v_cs_compress,$v_compress_level,$strPaddingKey).'</STATUS>'.$retorno_xml_values;
else
	$retorno_xml_values = '<STATUS>'.EnCrypt($key,$iv,'ERRO!',$v_cs_cipher,$v_cs_compress,$v_compress_level,$strPaddingKey).'</STATUS>';
		
$retorno_xml = $retorno_xml_header . $retorno_xml_values; 

echo $retorno_xml;	  
?>

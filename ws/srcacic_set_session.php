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
 Esse script tem como objetivo enviar ao servidor de suporte remoto na esta��o as configura��es (em XML) que s�o espec�ficas para a 
 esta��o em quest�o. S�o levados em considera��o a rede do agente, sistema operacional e Mac-Address.
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

$arrComputadores 	= getValores('computadores', 'te_palavra_chave'   , 'te_node_address = "'.$te_node_address.'" and id_so = '.$arrSO['id_so']);
$strTePalavraChave	= $arrComputadores['te_palavra_chave'];

// Valido a Palavra-Chave e monto a tripa com os nomes e ids dos dom�nios
if ($te_palavra_chave == $strTePalavraChave)
	{
	GravaTESTES('Palavra-Chave OK!'); 	
	conecta_bd_cacic();	

	if (!$_POST['id_sessao'])
		{
		// Identificador para Autentica��o no Dom�nio
		$id_dominio  		     = DeCrypt($key,$iv,$_POST['id_dominio']				,$v_cs_cipher,$v_cs_compress,$strPaddingKey); 
		$nm_nome_acesso_dominio	 = DeCrypt($key,$iv,$_POST['nm_nome_acesso_dominio']	,$v_cs_cipher,$v_cs_compress,$strPaddingKey); 
		$te_senha_acesso_dominio = DeCrypt($key,$iv,$_POST['te_senha_acesso_dominio']	,$v_cs_cipher,$v_cs_compress,$strPaddingKey); 
	
		$arrDominios = getValores('dominios',  'nm_dominio,
												te_ip_dominio,
												id_tipo_protocolo,
												nu_versao_protocolo,
												te_string_DN'   , 'id_dominio = '.$id_dominio.' AND in_ativo="S"');

		// Comunica��o com o servidor de Dom�nio, para autentica��o
		$ldap = ldap_connect($arrDominios['te_ip_dominio']);
		if (ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, $arrDominios['nu_versao_protocolo'])) 
			{
			ldap_bind($ldap);
			if (ldap_errno($ldap) == 0) 
				{
				ldap_bind($ldap, $arrDominios['nm_dominio']."\\".$nm_nome_acesso_dominio,$te_senha_acesso_dominio);
				if (ldap_errno($ldap) == 0) 
					{
					$searchResults = ldap_search($ldap, $arrDominios['te_string_DN'], 'cn=*'.$nm_nome_acesso_dominio.'*');
		
					// OK! Dados encontrados!
					if (!$searchResults === false)
						{
						$result 				= @ldap_get_entries($ldap, $searchResults);
						$nm_nome_completo  		= getBindedValue($result,'name');
						$te_email 				= getBindedValue($result,'mail');
						$dt_hr_inicio_sessao	= date('Y-m-d H:i:s');
						
						if ($te_email <> '')
							{
							// Envio e-mail informando da abertura de sess�o
							$corpo_mail = "Prezado usu�rio ".$nm_nome_completo.",\n\n
											informamos que foi iniciada uma sess�o para Suporte Remoto Seguro atrav�s do Sistema CACIC em ".$dt_hr_inicio_sessao . "\n\n\n\n
											_______________________________________________________________________
											CACIC - Configurador Autom�tico e Coletor de Informa��es Computacionais\n
											srCACIC - M�dulo para Suporte Remoto Seguro do Sistema CACIC\n
											Desenvolvido pela Dataprev - Unidade Regional Esp�rito Santo";
		
							// Manda mail para os administradores.
							mail("$te_email", "Sistema CACIC - M�dulo srCACIC - Abertura de Sess�o para Suporte Remoto Seguro", "$corpo_mail", "From: cacic@{$_SERVER['SERVER_NAME']}");
							}			
						$query_SESSAO = "INSERT INTO srcacic_sessoes 
													(dt_hr_inicio_sessao,
													 nm_nome_acesso_visitado,
													 nm_nome_completo_visitado,
													 te_node_address_visitado,
													 id_so_visitado)
										VALUES ('" . $dt_hr_inicio_sessao 		. "', 
												'" . $nm_nome_acesso_dominio 	. "',
												'" . $nm_nome_completo 			. "',									 
												'" . $te_node_address			. "',
												'" . $arrSO['id_so']			. "')";
						$result_SESSAO = mysql_query($query_SESSAO);	
						$arrSessoes = getValores('srcacic_sessoes','id_sessao','dt_hr_inicio_sessao="'.$dt_hr_inicio_sessao.'" AND
																				te_node_address_visitado="'.$te_node_address.'" AND
																				id_so_visitado = "'.$arrSO['id_so'].'"');

						$retorno_xml_values .= '<NM_COMPLETO>'.EnCrypt($key,$iv,$nm_nome_completo,$v_cs_cipher,$v_cs_compress,$v_compress_level,$strPaddingKey).'</NOME_COMPLETO>';						
						$retorno_xml_values .= '<ID_SESSAO>'.EnCrypt($key,$iv,$arrSessoes['id_sessao'],$v_cs_cipher,$v_cs_compress,$v_compress_level,$strPaddingKey).'</ID_SESSAO>';
						}
					}
				}
			}
		}
	else
		{
		$id_sessao 					= DeCrypt($key,$iv,$_POST['id_sessao'],$v_cs_cipher,$v_cs_compress,$strPaddingKey); 					
		$id_usuario_visitante 		= DeCrypt($key,$iv,$_POST['id_usuario_visitante'],$v_cs_cipher,$v_cs_compress,$strPaddingKey); 			
		$te_node_address_visitante 	= DeCrypt($key,$iv,$_POST['te_node_address_visitante'],$v_cs_cipher,$v_cs_compress,$strPaddingKey); 					
		$query_SESSAO = "UPDATE srcacic_sessoes 
						 SET	id_usuario_visitante = ".$id_usuario_visitante.",
						 		te_node_address_visitante = ".$te_node_address_visitante.",						 
						        dt_hr_ultimo_contato = '".date('d/m/Y �s H:i')."'
						 WHERE  id_sessao = ".$id_sessao;						 
		$result_SESSAO = mysql_query($query_SESSAO);			
		$retorno_xml_values .= '<OK>'.EnCrypt($key,$iv,'OK',$v_cs_cipher,$v_cs_compress,$v_compress_level,$strPaddingKey).'</OK>';		
		}
	}

if ($retorno_xml_values <> '')
	$retorno_xml_values = '<STATUS>'.EnCrypt($key,$iv,'OK',$v_cs_cipher,$v_cs_compress,$v_compress_level,$strPaddingKey).'</STATUS>'.$retorno_xml_values;
else
	$retorno_xml_values = '<STATUS>'.EnCrypt($key,$iv,'ERRO!',$v_cs_cipher,$v_cs_compress,$v_compress_level,$strPaddingKey).'</STATUS>';
			
$retorno_xml = $retorno_xml_header . $retorno_xml_values; 

echo $retorno_xml;	

// Fun��o para resgatar valores contidos no BIND retornado na autentica��o no dom�nio
function getBindedValue($arrBINDED,$strValue)
	{
	global $getBindedValue;
	for ($intVetor=0; $intVetor < count($arrBINDED);$intVetor++)
		{
		if (strtolower(gettype(current($arrBINDED)))=='array')
			getBindedValue(current($arrBINDED),$strValue);
		else
			if (current($arrBINDED) == $strValue)
				{
				$getBindedValue = $arrBINDED[current($arrBINDED)][0]; 
				break;
				}
		next($arrBINDED);
		}
	return $getBindedValue;
	}

//  
?>

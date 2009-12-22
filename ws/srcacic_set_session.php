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

function criaSessao($p_dt_hr_inicio_sessao,
					$p_nm_nome_acesso_autenticacao,
					$p_nm_nome_completo,
					$p_te_email,
					$p_te_node_address,
					$p_id_so)
	{				
	if ($p_te_email <> '')
		{
		// Envio e-mail informando da abertura de sess�o
		$corpo_mail = "Prezado usu�rio(a) ".$p_nm_nome_completo.",\n\n
						informamos que foi iniciada uma sess�o para Suporte Remoto Seguro atrav�s do Sistema CACIC em ".$p_dt_hr_inicio_sessao . "\n\n\n\n
							_______________________________________________________________________
							CACIC - Configurador Autom�tico e Coletor de Informa��es Computacionais\n
							srCACIC - M�dulo para Suporte Remoto Seguro do Sistema CACIC\n
							Desenvolvido pela Dataprev - Unidade Regional Esp�rito Santo";

		//GravaTESTES('SetSession: Enviando Email...');													
		// Manda mail para os administradores.
		//mail("$p_te_email", "Sistema CACIC - M�dulo srCACIC - Abertura de Sess�o para Suporte Remoto Seguro", "$corpo_mail", "From: cacic@{$_SERVER['SERVER_NAME']}");
		}			

	conecta_bd_cacic();
	
	$query_SESSAO = "INSERT INTO srcacic_sessoes 
								(	dt_hr_inicio_sessao,
								 	nm_acesso_usuario_srv,
								 	nm_completo_usuario_srv,
								 	te_email_usuario_srv,													 
								 	te_node_address_srv,
								 	id_so_srv,
								 	dt_hr_ultimo_contato)
					  VALUES ('" . $p_dt_hr_inicio_sessao			. "', 
							  '" . $p_nm_nome_acesso_autenticacao	. "',
							  '" . $p_nm_nome_completo 				. "',									
							  '" . $p_te_email 						. "',																					
							  '" . $p_te_node_address				. "',
							  '" . $p_id_so							. "',
							  '" . $p_dt_hr_inicio_sessao			. "')";
						GravaTESTES('SetSession: query_SESSAO: '.$query_SESSAO);																	
	$result_SESSAO = mysql_query($query_SESSAO);			
	}

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

// Algumas esta��es enviar�o uma string para extens�o de bloco
$strPaddingKey  	= '';

// Autentica��o da Esta��o Visitada
$te_node_address   	= DeCrypt($key,$iv,$_POST['te_node_address']				,$v_cs_cipher,$v_cs_compress,$strPaddingKey); 
$te_so             	= DeCrypt($key,$iv,$_POST['te_so']							,$v_cs_cipher,$v_cs_compress,$strPaddingKey); 
$te_palavra_chave  	= DeCrypt($key,$iv,urldecode($_POST['te_palavra_chave'])	,$v_cs_cipher,$v_cs_compress,$strPaddingKey); 
$id_sessao			= DeCrypt($key,$iv,$_POST['id_sessao']						,$v_cs_cipher,$v_cs_compress,$strPaddingKey); 

// ATEN��O: Apenas retornar� um ARRAY contendo "id_so" e "te_so".
$arrSO = inclui_computador_caso_nao_exista(	$te_node_address, 
											'',
											$te_so,
											'', 
											'', 
											'',
											'');									

$arrComputadores 	= getValores('computadores', 'te_palavra_chave,id_ip_rede' , 'te_node_address = "'.$te_node_address.'" and id_so = '.$arrSO['id_so']);
$arrRedes 			= getValores('redes'       , 'id_local'   				   , 'id_ip_rede= "'.$arrComputadores['id_ip_rede'].'"'); 
$strTePalavraChave	= $arrComputadores['te_palavra_chave'];


// Valido a Palavra-Chave e monto a tripa com os nomes e ids dos servidores de autentica��o
if ($te_palavra_chave == $strTePalavraChave)
	{
	conecta_bd_cacic();	

	if (!$id_sessao)
		{		
		// Identificador para Autentica��o no Servidor de Autentica��o
		$id_servidor_autenticacao	  	= DeCrypt($key,$iv,$_POST['id_servidor_autenticacao']		,$v_cs_cipher,$v_cs_compress,$strPaddingKey); 
		$nm_nome_acesso_autenticacao  	= DeCrypt($key,$iv,$_POST['nm_nome_acesso_autenticacao']	,$v_cs_cipher,$v_cs_compress,$strPaddingKey); 
		$te_senha_acesso_autenticacao 	= DeCrypt($key,$iv,$_POST['te_senha_acesso_autenticacao']	,$v_cs_cipher,$v_cs_compress,$strPaddingKey); 
		$nm_nome_completo  				= '';					
		$dt_hr_inicio_sessao			= date('Y-m-d H:i:s');								
		
		if ($id_servidor_autenticacao == '0')
			{
			$nm_nome_completo = 'Usu&aacute;rio N&atilde;o Autenticado';									
			criaSessao($dt_hr_inicio_sessao,
					   $nm_nome_acesso_autenticacao,
					   $nm_nome_completo,
					   $te_email,
					   $te_node_address,
					   $arrSO['id_so']);			
			}
		else
			{	
			$arrServidores = getValores('servidores_autenticacao',  
										'nm_servidor_autenticacao,
										te_ip_servidor_autenticacao,
										id_tipo_protocolo,
										nu_versao_protocolo,
										te_base_consulta_raiz,
										te_base_consulta_folha,
										te_atributo_identificador,
										te_atributo_retorna_nome,
										te_atributo_retorna_email'   , 
										'id_servidor_autenticacao = '.$id_servidor_autenticacao.' AND in_ativo="S"');
		
			/*	
			
			// APLICACAO DO BLOCO DE CODIGO DO JARBAS PEIXOTO - URMS
			// 1 - Fazer a pesquisa no OpenLDAP 
			// 2 - Contar os resultados
			// 2.1 - Caso resultado = 0 ERRO
			// 2.2 - Caso resultado > 1 ERRO
			// 2.3 - Caso resultado = 1 OK
			// 3 - No script, acontece a obtencao do DN do unico usuario encontrado
			// 4 - A partir do DN obtido, realizar o BIND.
			*/
		
			// Comunica��o com o servidor de Autentica��o
	
			$te_atributo_retorna_nome	= $arrServidores['te_atributo_retorna_nome'];
			$te_atributo_retorna_email	= $arrServidores['te_atributo_retorna_email'];		
			$te_host 					= $arrServidores['nm_servidor_autenticacao'];
	
			$ldap = ldap_connect($te_host,389);
			
			ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, $arrServidores['nu_versao_protocolo']);
	
			if (ldap_errno($ldap) == 0) 
				{
				$strRootDN = $arrServidores['te_base_consulta_raiz'];
				$strNodeDN = $arrServidores['te_base_consulta_folha'];
				
				$searchResults = ldap_search($ldap, "$strNodeDN,$strRootDN",$arrServidores['te_atributo_identificador'].'='.$nm_nome_acesso_autenticacao);				
				$ldapResults = ldap_get_entries($ldap, $searchResults);				
				
				$bind = ldap_bind($ldap, $ldapResults[0]["dn"], $te_senha_acesso_autenticacao);
				
				if ($bind)
					{			
					$nm_nome_completo  		= $ldapResults[0][strtolower($arrServidores['te_atributo_retorna_nome'])][0];					
					$te_email 				= $ldapResults[0][strtolower($arrServidores['te_atributo_retorna_email'])][0];					
						
					if ($nm_nome_completo <> '')
						criaSessao($dt_hr_inicio_sessao,
								   $nm_nome_acesso_autenticacao,
								   $nm_nome_completo,
								   $te_email,
								   $te_node_address,
								   $arrSO['id_so']);
					}
				}
			}

		if ($nm_nome_completo <> '')
			{
			$arrSessoes = getValores('srcacic_sessoes','id_sessao','dt_hr_inicio_sessao="'.$dt_hr_inicio_sessao.'" AND
																	te_node_address_srv="'.$te_node_address.'" AND
																	id_so_srv = "'.$arrSO['id_so'].'"');

			$retorno_xml_values .= '<NM_COMPLETO>'.EnCrypt($key,$iv,$nm_nome_completo,$v_cs_cipher,$v_cs_compress,$v_compress_level,$strPaddingKey).'</NM_COMPLETO>';						
			$retorno_xml_values .= '<ID_SESSAO>'.EnCrypt($key,$iv,$arrSessoes['id_sessao'],$v_cs_cipher,$v_cs_compress,$v_compress_level,$strPaddingKey).'</ID_SESSAO>';
			}			
		}
	else
		{
		$query_SESSAO = "UPDATE srcacic_sessoes 
						 SET	dt_hr_ultimo_contato = '".date('Y-m-d H:i:s')."'
						 WHERE  id_sessao = ".$id_sessao;												
		$result_SESSAO = mysql_query($query_SESSAO);			

		conecta_bd_cacic();			
		if ($_POST['te_mensagem']<>'')
			{
			$id_conexao 	= DeCrypt($key,$iv,$_POST['id_conexao']		,$v_cs_cipher,$v_cs_compress,$strPaddingKey); 								
			$te_mensagem   	= DeCrypt($key,$iv,$_POST['te_mensagem']	,$v_cs_cipher,$v_cs_compress,$strPaddingKey); 														
			$cs_origem   	= DeCrypt($key,$iv,$_POST['cs_origem']		,$v_cs_cipher,$v_cs_compress,$strPaddingKey); 																	
			
			$query_CHAT = "INSERT INTO srcacic_chats(id_conexao,dt_hr_mensagem,te_mensagem,cs_origem)
			 					  VALUES (".$id_conexao.",'".date('Y-m-d H:i:s')."','".$te_mensagem."','".$cs_origem."')";
			$result_CHAT = mysql_query($query_CHAT);			
			}
		else
			{
			// Verifico se o registro de conexao eh valido
			// Neste caso, testo se o valor que chega refere-se a "0" criptografado com uma determinada chave...
			if ($_POST['id_conexao'] <> 'pibWRa7Dc7gciUJjHEB4Ww==')
				{
				$arr_id_usuario_cli = explode('<REG>',DeCrypt($key,$iv,$_POST['id_usuario_cli']	,$v_cs_cipher,$v_cs_compress,$strPaddingKey));
				$arr_id_conexao		= explode('<REG>',DeCrypt($key,$iv,$_POST['id_conexao']		,$v_cs_cipher,$v_cs_compress,$strPaddingKey));		
				$arr_te_so_cli 	   	= explode('<REG>',DeCrypt($key,$iv,$_POST['te_so_cli']	 	,$v_cs_cipher,$v_cs_compress,$strPaddingKey));
				
				for ($i=0; $i < count($arr_id_usuario_cli); $i++)
					{
					$te_so_cli 		= $arr_te_so_cli[$i]; 								
					$id_conexao		= $arr_id_conexao[$i]; 											
					$arr_id_so_cli	= getValores('so','id_so','trim(te_so)="'.trim($te_so_cli).'"');

					/*
					E se o tecnico utilizar um notebook externo ao parque computacional da corporacao?
					Nao insiro a maquina do visitante...
					*/
					$query_SESSAO = "UPDATE srcacic_conexoes 
									 SET	dt_hr_ultimo_contato = '".date('Y-m-d H:i:s')."'							 		
									 WHERE  id_sessao  = ".$id_sessao ." and
											id_conexao = ".$id_conexao;
					$result_SESSAO = mysql_query($query_SESSAO);					
					}
				}
			}
		
		$retorno_xml_values .= '<OK>'.EnCrypt($key,$iv,'OK',$v_cs_cipher,$v_cs_compress,$v_compress_level,$strPaddingKey).'</OK>';		
		}
	}

if ($retorno_xml_values <> '')
	$retorno_xml_values = '<STATUS>'.EnCrypt($key,$iv,'OK',$v_cs_cipher,$v_cs_compress,$v_compress_level,$strPaddingKey).'</STATUS>'.$retorno_xml_values;
else
	$retorno_xml_values = '<STATUS>'.EnCrypt($key,$iv,'SetSession ERRO! '.ldap_error($ldap),$v_cs_cipher,$v_cs_compress,$v_compress_level,$strPaddingKey).'</STATUS>';

$retorno_xml = $retorno_xml_header . $retorno_xml_values; 
echo $retorno_xml;	
?>

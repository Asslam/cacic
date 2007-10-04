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
session_start();
require_once('../include/library.php');
// Comentado temporariamente - AntiSpy();

$id_acao = $_POST['id_acao']; 

// Leio o array 1 que cont�m as subredes N�O selecionadas...
$arrListaRedesNaoSelecionadas = $_POST['list1'];
$queryDEL = '';
for( $i = 0; $i < count($arrListaRedesNaoSelecionadas); $i++ ) 
	{
	$dadosRedes = explode('#',$arrListaRedesNaoSelecionadas[$i]);	

	if ($queryDEL)
		$queryDEL .= ' OR ';
		
    // Removo a a��o em quest�o da rede
	$queryDEL = "(id_acao    = '".$id_acao."' AND
				  id_ip_rede = '".$dadosRedes[0]."' AND
			  	  id_local   = ".$dadosRedes[1].")";							
	}
	
conecta_bd_cacic();	

if ($queryDEL)
	{
	$queryDEL = 'DELETE FROM acoes_redes WHERE '.$queryDEL;
	$result = mysql_query($queryDEL) or die('2-Ocorreu um erro durante a dele��o de registros na tabela acoes_redes ou sua sess�o expirou!'); 
	GravaLog('DEL',$_SERVER['SCRIPT_NAME'],'acoes_redes');				
	}	
	
	
// Leio o array 2 que cont�m as subredes selecionadas...
$arrListaRedesSelecionadas = $_POST['list2'];

// Caso n�o existam redes selecionadas, a situa��o torna-se em Nenhuma Rede
$cs_situacao = (count($arrListaRedesSelecionadas)>0?$_POST['cs_situacao']:'N');

// Caso tenha sido marcado "Em todas as redes", concateno o array 1, que cont�m as redes "n�o selecionadas".
if ($cs_situacao == 'T' || $cs_situacao == 'N')
	{
	if ($arrListaRedesSelecionadas)
		$arrListaRedesSelecionadas = array_merge($_POST['list1'],$_POST['list2']);
	else
		$arrListaRedesSelecionadas = $_POST['list1'];	
	}


for( $i = 0; $i < count($arrListaRedesSelecionadas); $i++ ) 
	{
	$dadosRedes = explode('#',$arrListaRedesSelecionadas[$i]);	

    // Removo a a��o em quest�o da rede
	$query = "DELETE	from acoes_redes 
			  WHERE 	id_acao    = '".$id_acao."' AND
						id_ip_rede = '".$dadosRedes[0]."' AND
			  			id_local   = ".$dadosRedes[1];
						
	$result = mysql_query($query) or die('2-Ocorreu um erro durante a dele��o de registros na tabela acoes_redes ou sua sess�o expirou!'); 
	GravaLog('DEL',$_SERVER['SCRIPT_NAME'],'acoes_redes');			

    // Removo todos os sistemas operacionais associadas � a��o em quest�o.
	$query = "DELETE 	
			  FROM 		acoes_so 
			  WHERE 	id_acao='".$id_acao."' AND
						id_local = ".$dadosRedes[1];
	$result = mysql_query($query) or die('6-Ocorreu um erro durante a dele��o de registros na tabela acoes_so ou sua sess�o expirou!'); 
	GravaLog('DEL',$_SERVER['SCRIPT_NAME'],'acoes_so');

	if ($cs_situacao <> 'N')
		{
		// Incluo todas os so's selecionados
		for( $j = 0; $j < count($_POST['list4']); $j++ ) 
			{
			$query = "INSERT 
				      INTO 		acoes_so (id_so, id_acao, id_local) 
					  VALUES 	('".$_POST['list4'][$j]."', '".$id_acao."', ".$dadosRedes[1].")";
			mysql_query($query) or die('7-Ocorreu um erro durante a inclus�o de registros na tabela acoes_so ou sua sess�o expirou!');
			GravaLog('INS',$_SERVER['SCRIPT_NAME'],'acoes_so');		
			}
		}

    // Removo todos os mac address associados � a��o em quest�o.
	$query = "DELETE 
			  FROM 		acoes_excecoes 
			  WHERE 	id_acao='".$id_acao."' AND
			            id_local=".$dadosRedes[1];
	$result = mysql_query($query) or die('8-Ocorreu um erro durante a dele��o de registros na tabela acoes_excecoes ou sua sess�o expirou!'); 
	GravaLog('DEL',$_SERVER['SCRIPT_NAME'],'acoes_excecoes');
	
	if ($cs_situacao <> 'N')
		{	
		// Incluo todas os mac address selecionados.
		for( $k = 0; $k < count($_POST['list5']); $k++ ) 
			{
			$query = "INSERT 
					  INTO 		acoes_excecoes (id_local,te_node_address, id_acao) 
					  VALUES 	(".$dadosRedes[1].",'".$_POST['list5'][$k]."', '".$id_acao."')";

			// N�o uso o die, pois n�o quero que sejam ecoadas mensagens de erro caso se tente gravar 
			// registros duplicados. lembre que � um ambiente multiusu�rio.
			mysql_query($query); 
			GravaLog('INS',$_SERVER['SCRIPT_NAME'],'acoes_excecoes');
			}
		}
	
	if($cs_situacao == 'S')
		{		
		$query = "INSERT	
				  INTO 		acoes_redes (id_ip_rede, 
				  			id_acao, 
							id_local, 
							cs_situacao,
							dt_hr_alteracao) 
				  VALUES 	('".$dadosRedes[0]."', 
				  			'".$id_acao."',".$dadosRedes[1].",
							'S',
							now())";					
		mysql_query($query) or die('3-Ocorreu um erro durante a inclus�o de registros selecionados na tabela acoes_redes ou sua sess�o expirou!');
		GravaLog('INS',$_SERVER['SCRIPT_NAME'],'acoes_redes');
		}
	elseif ($cs_situacao == 'T')		
		{	
		$query = "SELECT 	id_ip_rede
				   FROM 	redes
				   WHERE	id_local=".$dadosRedes[1];
		$result = mysql_query($query) or die('4-Deu erro ou sua sess�o expirou!');
			
		while($campos=mysql_fetch_array($result)) 
			{
			$query = "INSERT	
					  INTO 		acoes_redes (id_ip_rede, 
					  			id_acao, 
								id_local, 
								cs_situacao,
								dt_hr_alteracao) 
					  VALUES	('".$campos[0]."', 
					  			'".$id_acao."', 
								".$dadosRedes[1].",
								'T',
								now())";
			mysql_query($query) or die('5-Ocorreu um erro durante a inclus�o de TODOS registros na tabela acoes_redes ou sua sess�o expirou!');
			GravaLog('INS',$_SERVER['SCRIPT_NAME'],'acoes_redes');		
			}
		}											
	}

header ("Location: ../include/operacao_ok.php?chamador=../admin/modulos.php&tempo=1");	
?>

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

    conecta_bd_cacic();

    // Removo todas as redes associadas � a��o em quest�o.
	$query = "DELETE	from acoes_redes 
			  WHERE 	id_acao='$id_acao' AND
			  			id_local = ".$_SESSION['id_local'];
	$result = mysql_query($query) or die('2-Ocorreu um erro durante a dele��o de registros na tabela acoes_redes.'); 

	GravaLog('DEL',$_SERVER['SCRIPT_NAME'],'acoes_redes');	
// Incluo todas as redes selecionadas

if($_POST['cs_situacao'] == 'S')
	{
	for( $i = 0; $i < count($_POST['list2']); $i++ ) 
		{
		$query = "INSERT	
				  INTO 		acoes_redes (id_ip_rede, 
				  			id_acao, 
							id_local, 
							cs_situacao,
							dt_hr_alteracao) 
				  VALUES 	('".$_POST['list2'][$i]."', 
				  			'".$_POST['id_acao']."',".
							$_SESSION['id_local'].",'".
							$_POST['cs_situacao']."',
							now())";
		mysql_query($query) or die('3-Ocorreu um erro durante a inclus�o de registros selecionados na tabela acoes_redes.');
		GravaLog('INS',$_SERVER['SCRIPT_NAME'],'acoes_redes');
		}
}

if($_POST['cs_situacao'] == 'T')
	{
	$query1 = "SELECT 	id_ip_rede
			   FROM 	redes
			   WHERE	id_local=".$_SESSION['id_local'];
	$result = mysql_query($query1) or die('4-Deu erro');

	while($campos=mysql_fetch_array($result)) {
		$query = "INSERT	
				  INTO 		acoes_redes (id_ip_rede, 
				  			id_acao, 
							id_local, 
							cs_situacao,
							dt_hr_alteracao) 
				  VALUES	('".$campos[0]."', 
				  			'$id_acao', 
							".$_SESSION['id_local'].",
							'".$_POST['cs_situacao']."',
							now())";

		mysql_query($query) or die('5-Ocorreu um erro durante a inclus�o de TODOS registros na tabela acoes_redes.');
		GravaLog('INS',$_SERVER['SCRIPT_NAME'],'acoes_redes');		
	}
											
}

    // Removo todos os sistemas operacionais associadas � a��o em quest�o.
	$query = "DELETE 	
			  FROM 		acoes_so 
			  WHERE 	id_acao='$id_acao' AND
						id_local = ".$_SESSION['id_local'];

	$result = mysql_query($query) or die('6-Ocorreu um erro durante a dele��o de registros na tabela acoes_so.'); 
	GravaLog('DEL',$_SERVER['SCRIPT_NAME'],'acoes_so');

	// Incluo todas os so's selecionados
	for( $i = 0; $i < count($_POST['list4']); $i++ ) 
		{
		$query = "INSERT 
			      INTO 		acoes_so (id_so, id_acao, id_local) 
				  VALUES 	('".$_POST['list4'][$i]."', '".$_POST['id_acao']."', ".$_SESSION['id_local'].")";
		mysql_query($query) or die('7-Ocorreu um erro durante a inclus�o de registros na tabela acoes_so.');
		GravaLog('INS',$_SERVER['SCRIPT_NAME'],'acoes_so');		
		}

    // Removo todos os mac address associados � a��o em quest�o.
	$query = "DELETE 
			  FROM 		acoes_excecoes 
			  WHERE 	id_acao='".$_POST['id_acao']."'";
	$result = mysql_query($query) or die('8-Ocorreu um erro durante a dele��o de registros na tabela acoes_excecoes.'); 
	GravaLog('DEL',$_SERVER['SCRIPT_NAME'],'acoes_excecoes');
	// Incluo todas os mac address selecionados.
	for( $i = 0; $i < count($_POST['list5']); $i++ ) 
		{
		$query = "INSERT 
				  INTO 		acoes_excecoes (te_node_address, id_acao) 
				  VALUES 	('".$_POST['list5'][$i]."', '".$_POST['id_acao']."')";
		// N�o uso o die, pois n�o quero que sejam ecoadas mensagens de erro caso se tente gravar 
		// registros duplicados. lembre que � um ambiente multiusu�rio.
		mysql_query($query); 
		GravaLog('INS',$_SERVER['SCRIPT_NAME'],'acoes_excecoes');
		}

header ("Location: ../include/operacao_ok.php?chamador=../admin/modulos.php&tempo=1");	
?>

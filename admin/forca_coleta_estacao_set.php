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

require_once('../include/library.php');
// Comentado temporariamente - AntiSpy();
$acoes_computador = '';
foreach($HTTP_POST_VARS as $i => $v) 
	{
	if ($v && substr($i,0,9)=='cs_coleta')
		{
		if ($acoes_computador <> '')
			{
			$acoes_computador .= '#';			
			}
		$acoes_computador .= $v; 			
		}
	}

if ($acoes_computador)	
	{
	$query_computador .= '	Update 	computadores set dt_hr_coleta_forcada_estacao = now(),
														te_nomes_curtos_modulos="'.$acoes_computador.'" 
							Where 	te_node_address="'.trim($_POST['te_node_address']).'" AND
									id_so="'.trim($_POST['id_so']).'"'; 
	conecta_bd_cacic();									
	$result_computador = mysql_query($query_computador) or die('Ocorreu um erro durante a atualiza��o de computadores.'); 		
	GravaLog('UPD',$_SERVER['SCRIPT_NAME'],'computadores');		
	}
	header ("Location: ../include/operacao_ok.php?chamador=../index.html&tempo=1");	
?>

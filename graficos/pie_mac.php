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
  
include_once '../include/library.php'; 
include 	 '../include/piechart.php';
conecta_bd_cacic();
$where 	= ($_REQUEST['cs_nivel_administracao'] <> 1 &&
		   $_REQUEST['cs_nivel_administracao'] <> 2 ? ' AND b.id_local = '.$_REQUEST['id_local']:'');

$query = 'SELECT 	count(*) as qtd
          FROM 		computadores a,
					redes b
		  WHERE 	a.te_nome_computador IS NOT NULL AND 
			 	   	a.dt_hr_ult_acesso   IS NOT NULL AND
					a.id_ip_rede = b.id_ip_rede '.
					$where .' 
		  GROUP BY 	te_node_address';

$result = mysql_query($query) or die('Erro no select');

 		while ($row_result = mysql_fetch_assoc($result))		
			{ 
			$v_row_result = 'Quantidade Real Baseada em Mac-Address';
		    $arr[$v_row_result] ++;			
	 		} 
//		$array_legendas 	= array();
//		$array_quantidades 	= array();		
// 		while ($row_result 	= mysql_fetch_array($result))		
//		{ 
//		array_push($array_legendas,str_pad($row_result['te_desc_so'],20,'.',STR_PAD_RIGHT));
//		array_push($array_quantidades,$row_result['qtd']);
//	 	} 

   	$CreatePie = 0;
   	$Sort      = 1;		
	phPie($arr, 420 ,	50, $CenterX, $CenterY, $DiameterX, $DiameterY, $MinDisplayPct, $DisplayColors, $BackgroundColor, $LineColor, true, 3,$CreatePie, $Sort);

// class call with the width, height & data
//$pie = new PieGraph(420, 159, $array_quantidades, $array_legendas, 25);
// legends for the data
//$pie->setLegends($array_legendas);

// Height of the pie 3d effect
//$pie->set3dHeight(25);

// Display the graph
//$pie->display();
?>
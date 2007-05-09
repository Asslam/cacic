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
include_once '../include/library.php'; 
include_once '../include/piechart.php';
conecta_bd_cacic();
$where 	= ($_REQUEST['cs_nivel_administracao'] <> 1 &&
		   $_REQUEST['cs_nivel_administracao'] <> 2 ? ' AND b.id_local = '.$_REQUEST['id_local']:'');

if ($_SESSION['te_locais_secundarios'] && $where)
	{
	// Fa�o uma inser��o de "(" para ajuste da l�gica para consulta	
	$where = str_replace('b.id_local = ','(b.id_local = ',$where);
	$where .= ' OR b.id_local in ('.$_SESSION['te_locais_secundarios'].')) ';
	}

if ($_GET['in_detalhe'])
	$where = ' AND b.id_local = '.$_GET['in_detalhe'];

$query ='SELECT 	to_days(curdate()) - to_days(dt_hr_ult_acesso) as nr_dias, count(*)
		 FROM 		computadores a,
					redes b
		 WHERE  	a.te_nome_computador IS NOT NULL AND 
		 			a.dt_hr_ult_acesso IS NOT NULL AND
					a.id_ip_rede = b.id_ip_rede '.
					$where . ' 
		 GROUP BY 	nr_dias';

$result = mysql_query($query) or die('Erro no select');


$intSum = 0;
function qt_comp($result, $num_dias) 
	{
	global $intSum;
	mysql_data_seek($result, 0);
	while ($reg = mysql_fetch_array($result)) 
		{
		if ($reg[0] == $num_dias) 
			{
			$intSum += $reg[1];
			return $reg[1]; 
			}
		}
	}

function ha_mais_de($result, $num_dias_min, $num_dias_max) 
	{
	global $intSum;	
	$total_dias = 0;
	mysql_data_seek($result, 0);
	while ($reg = mysql_fetch_array($result)) 
		{
		if (($reg[0] > $num_dias_min) &&
			($reg[0] < $num_dias_max)) 					
			{
			$intSum += $reg[1];
			$total_dias = $total_dias + $reg[1]; 
			}
		}
		return $total_dias;
	}

$arr['Hoje................']	= qt_comp($result, 0);
$arr['H� 1 dia............'] 	= qt_comp($result, 1);  
$arr['H� 2 dias...........'] 	= qt_comp($result, 2); 
$arr['H� 3 dias...........'] 	= qt_comp($result, 3); 
$arr['H� 4 dias...........'] 	= qt_comp($result, 4); 
$arr['De 5 a 30 dias......'] 	= ha_mais_de($result, 4,30);      // De 4 dias a 1 m�s...
$arr['De 30 a 180 dias....'] 	= ha_mais_de($result, 29,180);	  // De 1 m�s a 6 meses...
$arr['De 180 a 365 dias...'] 	= ha_mais_de($result, 179,365);	  // De 6 meses a 1 ano...		
$arr['H� mais de 365 dias.'] 	= ha_mais_de($result, 364,99999); // De 1 ano em diante...

if ($intSum == 0)
	{
	$arr = array('a');
	}
	
$CreatePie 	= 1;
$Sort      	= 1;
$width 		= 420;
$height 	= 159;

phPie($arr, $width , $height, $CenterX, $CenterY, $DiameterX, $DiameterY, $MinDisplayPct, $DisplayColors, $BackgroundColor, $LineColor, true, 3,$CreatePie, $Sort); 
?>
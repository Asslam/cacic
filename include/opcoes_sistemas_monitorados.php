
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
	?>
<link href="cacic.css" rel="stylesheet" type="text/css">

	<tr><td colspan="4">&nbsp;</td></tr>
    <tr> 
	<td>&nbsp;</td>
    <td class="label" colspan="3">Sele&ccedil;&atilde;o para coleta de informa&ccedil;&otilde;es 
        de sistemas monitorados:<br></td>
    </tr>
    <tr> 
      <td colspan="4" height="1" bgcolor="#333333"></td>
    </tr>
    <tr> 
	<td>&nbsp;</td>
    <td colspan="3" class="descricao">Essa op&ccedil;&atilde;o 
          permitir&aacute; a sele&ccedil;&atilde;o de coletas de informa&ccedil;&otilde;es 
          de sistemas monitorados para essa rede.</font></td>
    </tr>	
 <tr> 
 <td colspan="4" height="1" bgcolor="#CCCCCC"></td>
 </tr>

<br>
<? 
// Se a chamada veio de ...detalhes_rede.php
$detalhes = strpos($_SERVER['REQUEST_URI'],'detalhes_rede');
if ($detalhes)
	{
	conecta_bd_cacic();			
	$query = "	SELECT 		*
				FROM 		aplicativos_redes
				WHERE		id_local = ".$_REQUEST['id_local']." AND
							id_ip_rede = '".$_REQUEST['id_ip_rede']."'"; 
	$result_aplicativos_redes = mysql_query($query) or die('Ocorreu um erro durante a consulta � tabela de redes com sistemas monitorados ou sua sess�o expirou!'); 
	$v_aplicativos_redes = '';
	while ($row = mysql_fetch_array($result_aplicativos_redes))
		{
		$v_aplicativos_redes .= '--' . $row['id_aplicativo'];
		}
	}
$query = "	SELECT 		*
			FROM 		perfis_aplicativos_monitorados
			ORDER BY	nm_aplicativo"; 						
$result_monitorados = mysql_query($query) or die('Ocorreu um erro durante a consulta � tabela de perfis de sistemas monitorados ou sua sess�o expirou!'); 
$total_registros = count($result_monitorados);
$seq = 0;
while ($row = mysql_fetch_array($result_monitorados))
	{ 
	if (!strpos($row['nm_aplicativo'], "#DESATIVADO#")>0) 
		{
		$seq ++;
		$id_aplicativo = '-'.$row['id_aplicativo'];
		$pos = strpos($v_aplicativos_redes,$id_aplicativo);
		?>
		<tr> 
		<td>&nbsp;</td>
		<td class="opcao_tabela" colspan="3"><div align="left"><? echo str_pad($seq,($total_registros>999?4:$total_registros>99?3:2),'0',STR_PAD_LEFT); ?> -  
		<input name="id_aplicativo_<? echo $row['id_aplicativo']; ?>" value="<? echo $row['id_aplicativo']; ?>" type="checkbox" class="normal" <? if ($pos || !$detalhes){ echo 'checked';} ?>>
		<? echo $row['nm_aplicativo'] ; ?></u></div></td>
		</tr>
		<?					
		}
	}				
?>
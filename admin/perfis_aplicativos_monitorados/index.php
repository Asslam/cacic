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
if ($_POST['submit']) {
  header ("Location: incluir_perfil.php");
}

include_once "../../include/library.php";
// Comentado temporariamente - AntiSpy();
Conecta_bd_cacic();

$query = 'SELECT 	* 
		  FROM 		perfis_aplicativos_monitorados 
		  ORDER BY 	nm_aplicativo';
$result = mysql_query($query);

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<link rel="stylesheet"   type="text/css" href="../../include/cacic.css">
<title>Cadastro de Perf&iacute;s de Aplicativos Monitorados</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body background="../../imgs/linha_v.gif">
<script language="JavaScript" type="text/javascript" src="../../include/cacic.js"></script>
<form name="form1" method="post" action="">
<table width="90%" border="0" align="center">
  <tr> 
    <td class="cabecalho">Cadastro 
      de Perfis de Sistemas Monitorados</td>
  </tr>
  <tr> 
    <td class="descricao">Neste m&oacute;dulo 
      dever&atilde;o ser cadastrados os perf&iacute;s dos sistemas a serem monitorados 
      pelo CACIC.</td>
  </tr>
</table>
<br><table border="0" align="center" cellpadding="0" cellspacing="1">
  <tr> 
    <td><div align="center">

          <input name="submit" type="submit" id="submit" value="  Incluir Novo Perfil de Sistema  " <? echo ($_SESSION['cs_nivel_administracao']<>1?'disabled':'')?>>

        
      </div></td>
  </tr>
  <tr> 
    <td height="10">&nbsp;</td>
  </tr>
  <tr> 
    <td height="10"><? echo $msg;?></td>
  </tr>

  <tr> 
    <td height="1" bgcolor="#333333"></td>
  </tr>
  <tr> 
    <td> <table border="0" cellpadding="2" cellspacing="0" bordercolor="#333333" align="center">
        <tr bgcolor="#E1E1E1"> 
          <td align="center"  nowrap>&nbsp;</td>
          <td align="center"  nowrap></td>
          <td align="center"  nowrap>&nbsp;</td>
          <td align="center"  nowrap class="cabecalho_tabela"><div align="left">Sistema 
              Monitorado</div></td>
          <td nowrap >&nbsp;</td>
            <td nowrap  class="cabecalho_tabela">Verifica&ccedil;&atilde;o Ativa</td>
        </tr>
	  <tr> 
    	<td height="1" bgcolor="#333333" colspan="6"></td>
	  </tr>
		
        <?  
if(mysql_num_rows($result)==0) 
	{
	$msg = '<div align="center">
			<font color="red" size="1" face="Verdana, Arial, Helvetica, sans-serif">
				Nenhum perfil de aplicativo cadastrado!
			</font><br><br></div>';
			
	}
else 
	{
	$Cor = 0;
	$NumRegistro = 1;
	
	while($row = mysql_fetch_array($result)) 
		{		  
	 	echo '<tr '. ($Cor==1?'bgcolor="#E1E1E1"':'').'>';
        echo '<td nowrap>&nbsp;</td>';
        echo '<td nowrap class="opcao_tabela"><div align="left">'.$NumRegistro.'</div></td>';
        echo '<td nowrap>&nbsp;</td>';
        echo '<td nowrap class="opcao_tabela"><div align="left"><a href="../perfis_aplicativos_monitorados/detalhes_perfil.php?id_aplicativo='.$row['id_aplicativo'].'">';
		if (strpos($row['nm_aplicativo'], "#DESATIVADO#")>0) 
			{
			echo substr($row['nm_aplicativo'], 0, strpos($row['nm_aplicativo'], "#DESATIVADO#"));
			}		  
		else
			{
			echo $row['nm_aplicativo']; 
			}
					
		echo '</a></div></td>';
        echo '<td nowrap>&nbsp;</td>';
        echo '<td nowrap ';
		if (strpos($row['nm_aplicativo'], "#DESATIVADO#")>0) 
			{
			echo 'class="destaque_laranja"><div align="center">N�O'; 
			}		  
		else
		  	{
			echo 'class="opcao_tabela"><div align="center">SIM'; 
			}
		echo '</td>';
		$Cor=!$Cor;
		$NumRegistro++;
	}
}
?>
      </table></td>
  </tr>
  <tr> 
    <td height="1" bgcolor="#333333"></td>
  </tr>
  <tr> 
    <td height="10">&nbsp;</td>
  </tr>
  <tr> 
    <td height="10"><? echo $msg;?></td>
  </tr>
  <tr> 
    <td><div align="center">
          <input name="submit" type="submit" id="submit" value="  Incluir Novo Perfil de Sistema  " <? echo ($_SESSION['cs_nivel_administracao']<>1?'disabled':'')?>>       
      </div></td>
  </tr>
</table>
</form>
<p>&nbsp;</p>
</body>
</html>

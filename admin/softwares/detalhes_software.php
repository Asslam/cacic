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
require_once('../../include/library.php');
// Comentado temporariamente - AntiSpy();
Conecta_bd_cacic();

if ($_REQUEST['ExcluiSoftware']) 
	{
	$query = "DELETE 
			  FROM 		softwares 
			  WHERE 	id_software = ".$_REQUEST['frm_id_software'];
	mysql_query($query) or die('Falha de dele��o na tabela softwares...');
	GravaLog('DEL',$_SERVER['SCRIPT_NAME'],'softwares');				
	header ("Location: ../../include/operacao_ok.php?chamador=../admin/softwares/index.php&tempo=1");									 				
	}
elseif ($_POST['GravaAlteracoes']) 
	{
	$query = "UPDATE	softwares
			SET
				nm_software	= '".$_POST['frm_nm_software']."',
				te_descricao_software	= '".$_POST['frm_te_descricao_software']."',
				qt_licenca	=  ".$_POST['frm_qt_licenca'].",
				nr_midia	= '".$_POST['frm_nr_midia']."', 
				te_local_midia	= '".$_POST['frm_te_local_midia']."',
				te_obs	= '".$_POST['frm_te_obs']."'
			  WHERE 	id_software = ".$_REQUEST['frm_id_software'];

	mysql_query($query) or die('Falha na atualiza��o da tabela Softwares...');
	GravaLog('UPD',$_SERVER['SCRIPT_NAME'],'softwares');
			
	header ("Location: ../../include/operacao_ok.php?chamador=../admin/softwares/index.php&tempo=1");									 					
}
else {
	$query = "SELECT *
		FROM 	softwares
		WHERE 	id_software = '".$_GET['id_software']."'";
	$result = mysql_query($query) or die ('Falha na consulta a tabela Softwares.');

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<link rel="stylesheet"   type="text/css" href="../../include/cacic.css">
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<SCRIPT LANGUAGE="JavaScript">

function valida_form()
        {
        if ( document.form.frm_nm_software.value == "" )
                {
                alert("O nome do Software � obrigat�rio.");
                document.form.frm_nm_software.focus();
                return false;
                }
        else if ( document.form.frm_te_descricao_software.value == "" )
                {
                alert("A descri��o do Software � obrigat�ria.");
                document.form.frm_te_descricao_software.focus();
                return false;
                }
        return true;
        }
</script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>


</head>
<?
$pos = substr_count($_SERVER['HTTP_REFERER'],'navegacao');
?>
<body <? if (!$pos) echo 'background="../../imgs/linha_v.gif"';?> onLoad="SetaCampo('frm_id_software')">
<script language="JavaScript" type="text/javascript" src="../../include/cacic.js"></script>

<form action="detalhes_software.php"  method="post" ENCTYPE="multipart/form-data" name="form" onSubmit="return valida_form()">
<table width="90%" border="0" align="center">
  <tr> 
      <td class="cabecalho">Detalhes do Software </td>
  </tr>
  <tr> 
      <td class="descricao">As informa&ccedil;&otilde;es abaixo referem-se a um 
        software previamente cadastrado no sistema.</td>
  </tr>
</table>

  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="1">


	<tr>
		<td class="label">
		<!--	<br> Nome:-->
		</td>
	</tr>
	<tr>
		<td ></td>
	</tr>
	<tr>
      		<td>
			<input name="frm_id_software" 
				type="hidden"
				size="3" 
				maxlength="4"
				class="normal" 
				onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);"
				value="<? echo mysql_result($result, 0,'id_software'); ?>"
				>
		</td>
	</tr>


    <tr> 
      <td class="label"><br>
        Nome:</td>
    </tr>
    <tr> 
      <td height="1" bgcolor="#333333"></td>
    </tr>
    <tr> 
      <td><input name="frm_nm_software" type="text" size="50" maxlength="150"  class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" value="<? echo mysql_result($result, 0, 'nm_software'); ?>" > 
      </td>
    </tr>
    <tr> 
      <td class="label"><div align="left">Descri&ccedil;&atilde;o:</div></td>
    </tr>
    <tr> 
      <td height="1" bgcolor="#333333"></td>
    </tr>
    <tr> 
      <td nowrap><input name="frm_te_descricao_software" type="text" id="frm_te_descricao_software" size="50" maxlength="255" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" value="<? echo mysql_result($result, 0, 'te_descricao_software'); ?>" ></td>
    </tr>
    <tr> 
      <td nowrap class="label"><br>
        Quantidade de Licen�as:</td>
    </tr>
    <tr> 
      <td height="1" bgcolor="#333333"></td>
    </tr>
    <tr> 
      <td nowrap> <input name="frm_qt_licenca" type="text" id="frm_qt_licenca" size="11" maxlength="11" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" value="<? echo mysql_result($result, 0, 'qt_licenca'); ?>"> 
    </tr>
    <tr> 
      <td nowrap class="label"><div align="left"><br>
          N�mero da M�dia:</div></td>
    </tr>
    <tr> 
      <td height="1" bgcolor="#333333"></td>
    </tr>
    <tr> 
      <td nowrap><input name="frm_nr_midia" type="text" id="frm_nr_midia"  size="11" maxlength="10" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" value="<? echo mysql_result($result, 0, 'nr_midia'); ?>"> 
    </tr>
    <tr> 
      <td nowrap class="label"><br>
        Localiza��o da M�dia:</td>
    </tr>
    <tr> 
      <td height="1" bgcolor="#333333"></td>
    </tr>
    <tr> 
      <td nowrap> <input name="frm_te_local_midia" type="text" id="frm_te_local_midia" size="50" maxlength="30" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" value="<? echo mysql_result($result, 0, 'te_local_midia'); ?>" > 
      </td>
    </tr>
    <tr> 
      <td nowrap class="label"><br>
        Observa��o:</td>
    </tr>
    <tr> 
      <td height="1" bgcolor="#333333"></td>
    </tr>
    <tr> 
      <td><input name="frm_te_obs" size="50" maxlength="200" id="frm_te_obs" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" value="<? echo mysql_result($result, 0, 'te_obs'); ?>"></td>
    </tr>
  </table>

<p align="center">
	<input name="GravaAlteracoes" 
		type="submit" 
		id="GravaAlteracoes" 
		value="  Gravar Altera&ccedil;&otilde;es  " 
		onClick="return Confirma('Confirma Informa��es da Altera��o?');"
		 <? echo ($_SESSION['cs_nivel_administracao']<>1 && $_SESSION['cs_nivel_administracao']<>3?'disabled':'')?>
	>
        &nbsp;&nbsp;
	<input name="ExcluiSoftware" 
		type="submit" 
		id="ExcluiSoftware" 
		value="  Excluir Software" 
		onClick="return Confirma('Confirma Exclus�o ?');"
		<? echo ($_SESSION['cs_nivel_administracao']<>1 && $_SESSION['cs_nivel_administracao']<>3?'disabled':'')?>
	>
	<input name="Retorna" 
		type="button" 
		value="  Retorna para <? echo str_replace("_"," ",$_REQUEST['nm_chamador']);?>  " 
		onClick="history.back()">
</p>

</form>
</body>
</html>
<?
}
?>

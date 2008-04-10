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
/*
 * verifica se houve login e tamb�m regras para outras verifica��es (ex: permiss�es do usu�rio)!
 */
if(!isset($_SESSION['id_usuario'])) 
  die('Acesso negado!');
else { // Inserir regras para outras verifica��es (ex: permiss�es do usu�rio)!
}

require_once('../../include/library.php');
AntiSpy();
conecta_bd_cacic(); ?>
 
<html>
<head>
<link rel="stylesheet"   type="text/css" href="../../include/cacic.css">
<title>Configura&ccedil;&atilde;o da Tela de Patrim&ocirc;nio</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<?
	 	$where = ($_SESSION['cs_nivel_administracao']<>1&&$_SESSION['cs_nivel_administracao']<>2?' AND id_local = '.$_SESSION['id_local']:'');
	 	$where = ' AND id_local = '.$_SESSION['id_local'];		
	   	$query = "SELECT 	te_etiqueta, 
							te_help_etiqueta, 
							te_plural_etiqueta 
				  FROM 		patrimonio_config_interface 
				  WHERE 	id_etiqueta = 'etiqueta1' " . 
				  			$where; 
		$result = mysql_query($query);
		$default = mysql_fetch_array($result);

?>

<body background="../../imgs/linha_v.gif">
<script language="JavaScript" type="text/javascript" src="../../include/cacic.js"></script>
<form name="form1" method="post" action="etiqueta_generica.php">
  <table width="600" border="0" align="center">
    <tr> 
      <td nowrap class="label">Texto 
        da &quot;Etiqueta 1&quot;:</td>
      <td><input name="te_etiqueta" type="text" id="te_etiqueta" value="<?  echo $default[0]  ?>" size="25" maxlength="50" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);"></td>
      <td class="descricao">Ex: Ger&ecirc;ncia</td>
    </tr>
    <tr> 
      <td nowrap class="label">Plural de Texto da &quot;Etiqueta 1&quot;:</td>
      <td><input name="te_plural_etiqueta" type="text" id="te_etiqueta" value="<?  echo $default[2]  ?>" size="25" maxlength="50" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);"></td>
      <td class="descricao">Ex: Ger&ecirc;ncias</td>
    </tr>
	
    <tr> 
      <td nowrap class="label">Texto de ajuda da &quot;Etiqueta 1&quot;:</td>
      <td><input name="te_help_etiqueta" type="text" id="te_help_etiqueta" value="<?  echo $default	[1]  ?>" size="25" maxlength="100" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);"></td>
      <td class="descricao">Ex: Selecione a Ger&ecirc;ncia de localiza&ccedil;&atilde;o este equipamento.</td>
    </tr>
    <tr> 
	
    <tr>
      <td colspan="3" nowrap><input name="id_etiqueta" type="hidden" value="etiqueta1">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="3" nowrap> <div align="center"> 
          <input name="gravar" type="submit" id="gravar" value="   Gravar   " onClick="return Confirma('Confirma Configura��o de Etiqueta 1?');" <? echo ($_SESSION['cs_nivel_administracao']<>1 && $_SESSION['cs_nivel_administracao']<>3?'disabled':'')?>>
        </div></td>
    </tr>
  </table>
</form>
</body>
</html>

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
 * verifica se houve login e tamb�m as permiss�es de usu�rio
 */
if(!isset($_SESSION['id_usuario'])) 
  die('Acesso negado!');
else { // Inserir regras para verificar permiss�es do usu�rio!
}
require_once('../include/library.php'); 
// Comentado temporariamente - AntiSpy();
?>
<html>
<head>
<link rel="stylesheet"   type="text/css" href="../include/cacic.css">
<title>Coleta For&ccedil;ada por Computador</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<? // O require abaixo ser� usado pelo inc_opcoes_administrativas/coleta_forcada.php - N�o remova! - A.A.P. 23/09/2004
require_once('../include/opcoes_avancadas_combos.js'); ?> 

</head>

<body>
<script language="JavaScript" type="text/javascript" src="../../include/cacic.js"></script>
<form action="forca_coleta_estacao_set.php"  method="post" ENCTYPE="multipart/form-data" name="forma">
<table width="90%" border="0" align="center">
  <tr> 
      <td class="cabecalho">Coleta For&ccedil;ada no Computador <u><em><? echo $_GET['te_nome_computador']; ?></em></u></td>
  </tr>
  <tr> 
      <td class="descricao">Esta p&aacute;gina permite for&ccedil;ar coletas em determinado computador.</td>
  </tr>

<br>
  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="1">
	<?
	$forca_coleta_estacao = 'OK'; // Vari�vel a ser verificada pela rotina em opcoes_avancadas.php
	require_once('../include/opcoes_avancadas.php');
	?>
    
    	<tr> 
      	<td height="1" bgcolor="#333333"></td>
    	</tr>
    	<tr> 
      	<td>&nbsp;</td>
    	</tr>
    	<tr> 
      	<td><div align="center"> 
        <input name="submit" type="submit" value="For�a Coletas">
        </div></td>
    	</tr>
  </table>
</table>
</form>
<p>&nbsp;</p>

</body>
</html>

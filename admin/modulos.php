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
conecta_bd_cacic();

$query = "SELECT 	acoes.id_acao,
					acoes.te_descricao_breve,
					acoes.te_descricao,
					acoes.te_nome_curto_modulo,
					acoes_redes.cs_situacao
		  FROM 		acoes LEFT JOIN acoes_redes ON (acoes.id_acao = acoes_redes.id_acao AND acoes_redes.id_local = ".$_SESSION['id_local'].")
		  GROUP BY	acoes.id_acao
		  ORDER BY 	acoes.id_acao";
if ($_SESSION['te_locais_secundarios']<>'')
	{
	// Fa�o uma inser��o de "(" para ajuste da l�gica para consulta
	$query = str_replace('acoes_redes.id_local = ','(acoes_redes.id_local = ',$query);
	$query = str_replace(')',' OR acoes_redes.id_local IN ('.$_SESSION['te_locais_secundarios'].')))',$query);	
	}
$result = mysql_query($query) or die('Erro no select ou sua sess�o expirou!');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<link rel="stylesheet"   type="text/css" href="../include/cacic.css">
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" background="../imgs/linha_v.gif">
<script language="JavaScript" type="text/javascript" src="../../include/cacic.js"></script>
<table width="90%" border="0" align="center">
  <tr> 
    <td class="cabecalho">M&oacute;dulos</td>
  </tr>
  <tr> 
    <td class="descricao"><p>Aqui voc&ecirc; 
        poder&aacute; configurar os v&aacute;rios m&oacute;dulos dispon&iacute;veis 
        do CACIC. Clique sobre o m&oacute;dulo desejado e, em seguida, realize 
        as configura&ccedil;&otilde;es.<br>&nbsp;<br>&nbsp;</p>
      </td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="1">
	<tr> 
	  <td height="1" colspan="2" bgcolor="#e7e7e7"></td>
	</tr>
        <tr> 
          <td height="5" colspan="2"></td>
        </tr>
	
  <tr> 
    <td>
<?  
while ($row = mysql_fetch_array($result)) 
	{
	$img = '';
	if($row['cs_situacao'] == 'N' || $row['cs_situacao'] == NULL)
		$img = '<img src="../imgs/alerta_vermelho.gif" title="N�o � executado em nenhuma rede" width="8" height="8" border="0">';
	if($row['cs_situacao'] == 'S')
		$img = '<img src="../imgs/alerta_amarelo.gif" title="Executado apenas nas redes selecionadas" width="8" height="8" border="0">';
	if($row['cs_situacao'] == 'T')
		$img = '<img src="../imgs/alerta_verde.gif" title="Executado em todas as redes" width="8" height="8" border="0">';
?>
	  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
        <tr> 
          <td class="label"><a href="acoes.php?id_acao=<? echo $row['id_acao']?>&te_descricao_breve=<? echo $row['te_descricao_breve']?>&te_descricao=<? echo $row['te_descricao']?>"><? echo $img. ' ' .$row['te_descricao_breve']?></a></td>
        </tr>
        <tr> 
          <td valign="top" scope="top" class="descricao"><div align="left"></div>
            <? echo $row['te_descricao']?>&nbsp;</td>
        </tr>
        <tr> 
          <td></td>
        </tr>
        <tr> 
          <td height="1" colspan="2" bgcolor="#e7e7e7"></td>
        </tr>
        <tr> 
          <td height="5" colspan="2"></td>
        </tr>
		
      </table>
<?
}
?>
	</td>
  </tr>
  <tr> 
    <td><div align="center"></div></td>
  </tr>
  <tr> 
    <td><div align="center"></div></td>
  </tr>
</table>
</body>
</html>

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
// Esse arquivo � um arquivo de include, usado pelo arquivo computador.php. 
if (!$_SESSION['software'])
	$_SESSION['software'] = false;
if ($exibir == 'software')
	{
	$_SESSION['software'] = !($_SESSION['software']);
	}
else
	{
	$_SESSION['software'] = false;
	}
$strCor = '';  
$strCor = ($strCor==''?'#CCCCFF':'');						  

?>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="1">
  <tr> 
    <td colspan="5" height="1" bgcolor="#333333"></td>
  </tr>
  <tr bgcolor="#E1E1E1"> 
    <td colspan="5" class="cabecalho_tabela">&nbsp;<a href="computador.php?exibir=software&te_node_address=<? echo $_GET['te_node_address']?>&id_so=<? echo $_GET['id_so']?>"> 
      <img src="../../imgs/<? if($_SESSION['software'] == true) echo 'menos';
   			 else echo 'mais'; ?>.gif" width="12" height="12" border="0"> Vers&otilde;es 
      de Softwares B&aacute;sicos</a></td>
  </tr>
  <tr> 
    <td colspan="5" height="1" bgcolor="#333333"></td>
  </tr>
  <?
			if ($_SESSION['software'] == true) {
			// EXIBIR INFORMA��ES DE SOFTWARE DO COMPUTADOR
				$query = "SELECT 	cs_situacao
						  FROM 		acoes_redes 
						  WHERE 	id_acao = 'cs_coleta_software' AND
						  			id_ip_rede = '".mysql_result($result,0,'id_ip_rede')."'";
				$result_acoes =  mysql_query($query);
				
				if (mysql_result($result_acoes, 0, "cs_situacao") <> 'N') {
					$query = "SELECT * FROM versoes_softwares
							  WHERE te_node_address = '".$_GET['te_node_address']."' AND 
							  		id_so = '". $_GET['id_so'] ."'";
					$result_software = mysql_query($query);
					if(mysql_num_rows($result_software) > 0) {
		?>
  <tr bgcolor="<? echo $strCor;?>"> 
    <td>&nbsp;</td>
    <td class="opcao_tabela">Sistema Operacional:</td>
    <td class="dado"><? echo mysql_result($result, 0, "te_desc_so"); ?></td>
    <td class="opcao_tabela">Vers&atilde;o do DirectX:</td>
    <td class="dado"><? echo mysql_result($result_software, 0, "te_versao_directx"); ?></td>
  </tr>
  <? echo $linha;
  $strCor = ($strCor==''?'#CCCCFF':'');						  
  ?> 

  <tr bgcolor="<? echo $strCor;?>"> 
    <td>&nbsp;</td>
    <td class="opcao_tabela">Vers&atilde;o do Internet Explorer:</td>
    <td class="dado"><? echo mysql_result($result_software, 0, "te_versao_ie"); ?></td>
    <td class="opcao_tabela">Vers&atilde;o do ODBC:</td>
    <td class="dado"><? echo mysql_result($result_software, 0, "te_versao_odbc"); ?></td>
  </tr>
  <? echo $linha;
  $strCor = ($strCor==''?'#CCCCFF':'');						  
  ?> 

  <tr bgcolor="<? echo $strCor;?>"> 
    <td>&nbsp;</td>
    <td class="opcao_tabela">Vers&atilde;o do Mozilla:</td>
    <td class="dado"><div align="left"><? echo mysql_result($result_software, 0, "te_versao_mozilla"); ?></div></td>
    <td class="opcao_tabela">Vers&atilde;o do DAO:</td>
    <td class="dado"><? echo mysql_result($result_software, 0, "te_versao_dao"); ?></td>
  </tr>
  <? echo $linha;
  $strCor = ($strCor==''?'#CCCCFF':'');						  
  ?> 

  <tr bgcolor="<? echo $strCor;?>"> 
    <td>&nbsp;</td>
    <td class="opcao_tabela">Vers&atilde;o do Acrobat Reader:</td>
    <td class="dado"><? echo mysql_result($result_software, 0, "te_versao_acrobat_reader"); ?></td>
    <td class="opcao_tabela">Vers&atilde;o do ADO:</td>
    <td class="dado"><? echo mysql_result($result_software, 0, "te_versao_ado"); ?></td>
  </tr>
  <? echo $linha;
  $strCor = ($strCor==''?'#CCCCFF':'');						  
  ?> 

  <tr bgcolor="<? echo $strCor;?>"> 
    <td>&nbsp;</td>
    <td class="opcao_tabela">Vers&atilde;o do Java Runtime (JVM):</td>
    <td class="dado"><? echo mysql_result($result_software, 0, "te_versao_jre"); ?></td>
    <td>Vers&atilde;o do BDE:</td>
    <td class="dado"><? echo mysql_result($result_software, 0, "te_versao_bde"); ?></td>
  </tr>
  <? echo $linha;
  $strCor = ($strCor==''?'#CCCCFF':'');						  
  ?> 

  <tr> 
    <td>&nbsp;</td>
    <td colspan="4">&nbsp; </td>
  </tr>
  <?
				}
				else {
					echo '<tr><td> 
							<p>
							<div align="center">
							<br>
							<font font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#FF0000">
							N�o foram coletadas informa��es de software referente a esta m�quina
							</font></div>
							</p>
						  </td></tr>';
				}
			}
			else {
				echo '<tr><td> 
						<div align="center">
						<font font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#FF0000">
						O m�dulo de Coleta de Informa��es de Software n�o foi habilitado pelo Administrador do CACIC.
						</font></div>
					  </td></tr>';
			}
		}
		// FIM DA EXIBI��O DE INFORMA��ES DE SOFTWARE DO COMPUTADOR
		?>
</table>

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
// Esse arquivo � um arquivo de include, usado pelo arquivo compuatdor.php. 
if (!$_SESSION['compartilhamento'])
	$_SESSION['compartilhamento'] = false;
if ($exibir == 'compartilhamento')
	{
	$_SESSION['compartilhamento'] = !($_SESSION['compartilhamento']);
	}
else
	{
	$_SESSION['compartilhamento'] = false;
	}
	
?>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="1">
  <tr> 
    <td> </td>
  </tr>
  <tr> 
    <td height="1" bgcolor="#333333"></td>
  </tr>
  <tr> 
    <td bgcolor="#E1E1E1" class="cabecalho_tabela">&nbsp;<a href="computador.php?exibir=compartilhamento&te_node_address=<? echo $_GET['te_node_address']?>&id_so=<? echo $_GET['id_so']?>"> 
      <img src="../../imgs/<? if($_SESSION['compartilhamento'] == true) echo 'menos';
   			 else echo 'mais'; ?>.gif" width="12" height="12" border="0"> 
      Compartilhamentos de Diret&oacute;rios e Impressoras</a></td>
  </tr>
  <tr> 
    <td height="1" bgcolor="#333333"></td>
  </tr>
  <?
		if ($_SESSION['compartilhamento'] == true) {

				$query = "SELECT 	cs_situacao
						  FROM 		acoes_redes
						  WHERE 	id_acao = 'cs_coleta_compart' AND
						  			id_ip_rede = '".mysql_result($result,0,'id_ip_rede')."'";
					$result_acoes =  mysql_query($query);
				
				if (mysql_result($result_acoes, 0, "cs_situacao") <> 'N') {
	
        		// EXIBIR INFORMA��ES DOS COMPARTILHAMENTOS DO COMPUTADOR
									$query = "SELECT 	* 
											  FROM 		compartilhamentos
											  WHERE 	te_node_address = '". $_GET['te_node_address'] ."' AND 
														id_so = '". $_GET['id_so'] ."'";
									$result_compartilhamento = mysql_query($query) or die('Erro no Select dos compartilhamentos');
									if(mysql_num_rows($result_compartilhamento) > 0) {
										echo '<tr><td><br> 
													<table width="98%" border="1" align="center" cellpadding="1" cellspacing="0" bordercolor="#999999" bordercolordark="#E1E1E1">
													<tr bgcolor="#FFFFCC">';
													
										if( mysql_result($result_compartilhamento, 0, "id_so") <= 5 ) {
											echo '<td nowrap rowspan="2" class="opcao_tabela"><div align="center">&nbsp;</div></td>
												  <td nowrap rowspan="2" class="opcao_tabela"><div align="center">Nome</div></td>
												  <td nowrap rowspan="2" class="opcao_tabela"><div align="center">Diret&oacute;rio</div></td>
												  <td nowrap rowspan="2" class="opcao_tabela"><div align="center">Coment�rio</div></td>
												  <td nowrap rowspan="2" class="opcao_tabela"><div align="center">Tipo</div></td>';
										}
										else {
											echo '<td nowrap class="opcao_tabela"><div align="center">Nome</div></td>
												  <td nowrap class="opcao_tabela"><div align="center">Diret&oacute;rio</div></td>
												  <td nowrap class="opcao_tabela"><div align="center">Coment�rio</div></td>
												  <td nowrap class="opcao_tabela"><div align="center">Tipo</div></td>';
										}
													
										if( mysql_result($result_compartilhamento, 0, "id_so") <= 5 ) {
											echo '	<td nowrap rowspan="2" class="opcao_tabela"><div align="center">Permiss&atilde;o</div></td>
													<td nowrap colspan="2" class="opcao_tabela"><div align="center">Senha</div></td>
													</tr>
													<tr bgcolor="#E1E1E1">
													<td nowrap  bgcolor="#FFFFCC" class="opcao_tabela"><div align="center">Leitura</div></td>
													<td nowrap  bgcolor="#FFFFCC" class="opcao_tabela"><div align="center">Grava��o</div></td>
													</tr>';
										}
										else						
											echo '</tr>'; 
										if( mysql_result($result_compartilhamento, 0, "id_so") <= 5 ) {	              
											$result_compartilhamento = mysql_query($query);																				
											while($row = mysql_fetch_assoc($result_compartilhamento)) {
													$img_alerta == '&nbsp;';
													if ($row['cs_tipo_compart'] == 'D')
													$tipo_compart = '<img src="../../imgs/compart_dir.gif" title="Compartilhamento de Diret�rio">';
													else
													$tipo_compart = '<img src="../../imgs/compart_print.gif" title="Compartilhamento de Impressora">';
													
													if( $row['in_senha_leitura'] == 1 )
														$senha_leitura = '<img src="../../imgs/checked.gif">';
													else {
														$senha_leitura = '<img src="../../imgs/unchecked.gif">';
													$img_alerta = '<img src="../../imgs/alerta_amarelo.gif" title="Risco M�dio: Privacidade" width="8" height="8">';
													}
													
													if( $row['in_senha_escrita'] == 1 )
														$senha_escrita = '<img src="../../imgs/checked.gif">';
													else {
														$senha_escrita = '<img src="../../imgs/unchecked.gif">';
													$img_alerta = '<img src="../../imgs/alerta_vermelho.gif" title="Risco Alto: Integridade e Privacidade" width="8" height="8">';
													}
													
													if( $row['cs_tipo_permissao'] == 'L' )
														$tipo_permissao = 'Leitura';
													if( $row['cs_tipo_permissao'] == 'G' )
														$tipo_permissao = 'Grava�ao';
													if( $row['cs_tipo_permissao'] == 'D' )
														$tipo_permissao = 'Depende de Senha';
													
													echo '<tr>						  
														<td nowrap align="center" class="opcao_tabela">'. $img_alerta .'</td>
														<td nowrap class="opcao_tabela">&nbsp;'. $row['nm_compartilhamento'] .'</td>
														<td nowrap class="opcao_tabela">&nbsp;'. quebra_linha(strtolower($row['nm_dir_compart']), 32) .'</td>
														<td nowrap class="opcao_tabela">&nbsp;'. capa_string($row['te_comentario'], 28) .'</td>
														<td nowrap align="center" class="opcao_tabela">'. $tipo_compart .'</td>
														<td nowrap class="opcao_tabela">&nbsp;'. $tipo_permissao .'</td>
														<td nowrap align="center" class="opcao_tabela">'. $senha_leitura .'</td>
														<td nowrap align="center" class="opcao_tabela">'. $senha_escrita .'</td>
																</tr>';
											}
										}
										else {
											$result_compartilhamento = mysql_query($query);										
											while($row = mysql_fetch_assoc($result_compartilhamento)) {
													if ($row['cs_tipo_compart'] == 'D')
													$tipo_compart = '<img src="../../imgs/compart_dir.gif" title="Compartilhamento de Diret�rio">';
													else
													$tipo_compart = '<img src="../../imgs/compart_print.gif" title="Compartilhamento de Impressora">';
													
													echo '<tr>						  
														<td nowrap class="dado">&nbsp;'. $row['nm_compartilhamento'] .'</td>
														<td nowrap class="opcao_tabela">&nbsp;'. quebra_linha(strtolower($row['nm_dir_compart']), 68) .'</td>
														<td nowrap class="opcao_tabela">&nbsp;'. capa_string($row['te_comentario'], 28) .'</td>
														<td nowrap align="center" class="opcao_tabela">'. $tipo_compart .'</td>
																</tr>';
											}
										}
										echo '</table></td></tr>';
										?>
  <tr> 
    <td>&nbsp;&nbsp;</td>
  </tr>
  <?
									}
									else {
										echo '<tr><td> 
												<p>
												<div align="center">
												<br>
												<font font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#FF0000">
												N�o existem compartilhamentos nesta m�quina
												</font></div>
												</p>
													</td></tr>';
									}
								}
								else {
									echo '<tr><td> 
											<div align="center">
											<font font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#FF0000">
											O m�dulo de coleta de informa��es sobre Compartilhamentos de Diret�rios e<br>Impressoras n�o foi habilitado pelo Administrador do CACIC.
											</font></div>
												</td></tr>';
								}
								// FIM DA EXIBI��O DE INFORMA��ES DOS COMPARTILHAMENTOS DO COMPUTADOR
					}
		?>
</table>

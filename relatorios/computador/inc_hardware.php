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
if (!$_SESSION['hardware'])
	$_SESSION['hardware'] = false;
if ($exibir == 'hardware')
	{
	$_SESSION['hardware'] = !($_SESSION['hardware']);
	}
else
	{
	$_SESSION['hardware'] = false;
	}
?>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="1">
  <tr> 
    <td colspan="3" height="1" bgcolor="#333333"></td>
  </tr>
  <tr> 
    <td colspan="3" bgcolor="#E1E1E1" class="cabecalho_tabela">&nbsp;<a href="computador.php?exibir=hardware&te_node_address=<? echo $_GET['te_node_address']?>&id_so=<? echo $_GET['id_so']?>"> 
      <img src="../../imgs/<? if($_SESSION['hardware'] == true) echo 'menos';
   			 else echo 'mais'; ?>.gif" width="12" height="12" border="0"> Hardware  Instalado</a></td>
  </tr>
  <tr> 
    <td colspan="3" height="1" bgcolor="#333333"></td>
  </tr>
  <?
  $strCor = '';  
  $strCor = ($strCor==''?'#CCCCFF':'');						  
		if ( $_SESSION['hardware'] == true) {
		// EXIBIR INFORMA��ES DE HARDWARE DO COMPUTADOR
			$query = "SELECT 	cs_situacao
					  FROM 		acoes_redes 
					  WHERE 	id_acao = 'cs_coleta_hardware' AND
					  			id_ip_rede = '".mysql_result($result,0,'id_ip_rede')."'";
			$result_acoes =  mysql_query($query);
			if (mysql_result($result_acoes, 0, "cs_situacao") <> 'N') {
		?>
  <? echo $linha;
  $strCor = ($strCor==''?'#CCCCFF':'');						  
  ?> 

  <tr bgcolor="<? echo $strCor;?>"> 
    <td>&nbsp;</td>
    <td class="opcao_tabela">Placa M&atilde;e:</td>
    <td class="dado"><? echo mysql_result($result, 0, "te_placa_mae_desc"); ?></td>
  </tr>
  <? echo $linha;
  $strCor = ($strCor==''?'#CCCCFF':'');						  
  ?> 

  <tr bgcolor="<? echo $strCor;?>"> 
    <td>&nbsp;</td>
    <td class="opcao_tabela">Fabricante da Placa M&atilde;e:</td>
    <td class="dado"><? echo mysql_result($result, 0, "te_placa_mae_fabricante"); ?></td>
  </tr>
  <? echo $linha;
  $strCor = ($strCor==''?'#CCCCFF':'');						  
  ?> 

  <tr bgcolor="<? echo $strCor;?>"> 
    <td>&nbsp;</td>
    <td class="opcao_tabela">Placa de V&iacute;deo:</td>
    <td class="dado"><? echo mysql_result($result, 0, "te_placa_video_desc"); ?></td>
  </tr>
  <? echo $linha;
  $strCor = ($strCor==''?'#CCCCFF':'');						  
  ?> 

  <tr bgcolor="<? echo $strCor;?>"> 
    <td>&nbsp;</td>
    <td class="opcao_tabela">Quant. Cores placa de V&iacute;deo:</td>
    <td class="dado"><? echo mysql_result($result, 0, "qt_placa_video_cores"); ?></td>
  </tr>
  <? echo $linha;
  $strCor = ($strCor==''?'#CCCCFF':'');						  
  ?> 

  <tr bgcolor="<? echo $strCor;?>"> 
    <td>&nbsp;</td>
    <td class="opcao_tabela">Resolu&ccedil;&atilde;o da Placa de V&iacute;deo:</td>
    <td class="dado"><? echo mysql_result($result, 0, "te_placa_video_resolucao"); ?></td>
  </tr>
  <? echo $linha;
  $strCor = ($strCor==''?'#CCCCFF':'');						  
  ?> 

  <tr bgcolor="<? echo $strCor;?>"> 
    <td>&nbsp;</td>
    <td class="opcao_tabela">Mem. da Placa de V&iacute;deo:</td>
    <td class="dado"><? echo mysql_result($result, 0, "qt_placa_video_mem").' MB'; ?></td>
  </tr>
  <? echo $linha;
  $strCor = ($strCor==''?'#CCCCFF':'');						  
  ?> 

  <tr bgcolor="<? echo $strCor;?>"> 
    <td>&nbsp;</td>
    <td class="opcao_tabela">Mem&oacute;ria RAM:</td>
    <td class="dado"><? echo mysql_result($result, 0, 'qt_mem_ram').' MB'; ?></td>
  </tr>
  <? echo $linha;
  $strCor = ($strCor==''?'#CCCCFF':'');						  
  ?> 

  <tr bgcolor="<? echo $strCor;?>"> 
    <td>&nbsp;</td>
    <td class="opcao_tabela">Detalhes da Mem&oacute;ria RAM:</td>
    <td class="dado"><? echo mysql_result($result, 0, "te_mem_ram_desc"); ?></td>
  </tr>
  <? echo $linha;
  $strCor = ($strCor==''?'#CCCCFF':'');						  
  ?> 

  <tr bgcolor="<? echo $strCor;?>"> 
    <td>&nbsp;</td>
    <td class="opcao_tabela">Descri&ccedil;&atilde;o da BIOS:</td>
    <td class="dado"><? echo mysql_result($result, 0, "te_bios_desc"); ?></td>
  </tr>
  <? echo $linha;
  $strCor = ($strCor==''?'#CCCCFF':'');						  
  ?> 

  <tr bgcolor="<? echo $strCor;?>"> 
    <td>&nbsp;</td>
    <td class="opcao_tabela">Fabricante da BIOS:</td>
    <td class="dado"><? echo mysql_result($result, 0, "te_bios_fabricante"); ?></td>
  </tr>
  <? echo $linha;
  $strCor = ($strCor==''?'#CCCCFF':'');						  
  ?> 

  <tr bgcolor="<? echo $strCor;?>"> 
    <td>&nbsp;</td>
    <td class="opcao_tabela">Placa de Som:</td>
    <td class="dado"><? echo mysql_result($result, 0, "te_placa_som_desc"); ?></td>
  </tr>
  <? echo $linha;
  $strCor = ($strCor==''?'#CCCCFF':'');						  
  ?> 

  <tr bgcolor="<? echo $strCor;?>"> 
    <td>&nbsp;</td>
    <td class="opcao_tabela">Modem:</td>
    <td class="dado"><? echo mysql_result($result, 0, "te_modem_desc"); ?></td>
  </tr>
  <? echo $linha;
  $strCor = ($strCor==''?'#CCCCFF':'');						  
  ?> 

  <tr bgcolor="<? echo $strCor;?>"> 
    <td>&nbsp;</td>
    <td class="opcao_tabela">Teclado:</td>
    <td class="dado"><? echo mysql_result($result, 0, "te_teclado_desc"); ?></td>
  </tr>
  <? echo $linha;
  $strCor = ($strCor==''?'#CCCCFF':'');						  
  ?> 

  <tr bgcolor="<? echo $strCor;?>"> 
    <td>&nbsp;</td>
    <td class="opcao_tabela">Mouse:</td>
    <td class="dado"><? echo mysql_result($result, 0, "te_mouse_desc"); ?></td>
  	</tr>
  	<? 
  	echo $linha;
  	$strCor = ($strCor==''?'#CCCCFF':'');						  

	conecta_bd_cacic();
	// Consulto lista de colunas de hardware
	$queryDescricoesColunas  = "SELECT 	nm_campo, 
										te_descricao_campo
								FROM 	descricoes_colunas_computadores";
	$resultDescricoesColunas = mysql_query($queryDescricoesColunas) or die('Ocorreu um erro durante a consulta � tabela descricoes_colunas_computadores.');

	// Crio um array que conter� nm_campo => te_descricao_campo.	 
	$arrDescricoesColunas = array();			
	while($rowColunasComputadores = mysql_fetch_array($resultDescricoesColunas)) 	
		$arrDescricoesColunas[trim($rowColunasComputadores['nm_campo'])] = $rowColunasComputadores['te_descricao_campo'];
  
	$strQueryTotalizaGeralExistentes = ' SELECT  	cs_tipo_componente,
												 	te_valor
								 		 FROM	 	componentes_estacoes
										 WHERE   	te_node_address = "'.mysql_result($result, 0, "te_node_address") . '" AND
									 		 	  			   id_so='  . mysql_result($result, 0, "id_so").'
										 ORDER BY 	cs_tipo_componente,te_valor';
	$resultTotalizaGeralExistentes   = mysql_query($strQueryTotalizaGeralExistentes) or die('Problema Consultando Tabela Componentes_Esta��es 1!');

	$strComponenteAtual = '';
	$intSequencial      = 0;
  	while ($rowTotalizaGeralExistentes = mysql_fetch_array($resultTotalizaGeralExistentes))
  		{
		if ($strComponenteAtual <> $rowTotalizaGeralExistentes['te_valor'])
			{
			$strComponenteAtual = $rowTotalizaGeralExistentes['te_valor'];
			?> 
			<tr bgcolor="<? echo $strCor;?>"> 
			<?			
			}

		$arrColunasValores = explode('#FIELD#',$rowTotalizaGeralExistentes['te_valor']);
		for ($i=0; $i<count($arrColunasValores);$i++)
			{
			$arrColunas = explode('###',$arrColunasValores[$i]);		
			<td>&nbsp;</td>
			<td class="opcao_tabela"><? echo $arrDescricoesColunas[$arrColunas[0]];?>:</td>
			<td class="dado"><? echo $arrColunas[1]; ?></td>
			</tr>
			<?
			}
		}
	echo $linha;
  	$strCor = ($strCor==''?'#CCCCFF':'');						  		
  	?> 
  	<tr> 
    <td>&nbsp;</td>
    <td colspan="2"> <form action="historico.php" method="post" name="form1" target="_blank">
        <div align="center"><br>
          <input name=historico_hardware type=submit id=historico_hardware value="Hist&oacute;rico de Altera&ccedil;&otilde;es na Configura&ccedil;&atilde;o de Hardware" >
          <br>
          &nbsp; 
          <input name="te_node_address" type="hidden" id="te_node_address" value="<? echo mysql_result($result, 0, "te_node_address");?>">
          <input name="id_so" type="hidden" id="id_so" value="<? echo mysql_result($result, 0, "id_so");?>">
        </div>
      </form></td>
  </tr>
  <?		
			}
			else {
				echo '<tr><td> 
						<div align="center">
						<font font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#FF0000">
						O m�dulo de Coleta de Informa��es de Hardware n�o foi habilitado pelo Administrador do CACIC.
						</font></div>
					  </td></tr>';
			}
		}
		// FIM DA EXIBI��O DE INFORMA��ES DE HARDWARE DO COMPUTADOR
		?>
</table>

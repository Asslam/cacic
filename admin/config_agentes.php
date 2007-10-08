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
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<? 
require_once('../include/opcoes_avancadas_combos.js');  
?>
<link rel="stylesheet"   type="text/css" href="../include/cacic.css">
</head>

<body background="../imgs/linha_v.gif"  onLoad="SetaCampo('in_exibe_bandeja');">
<?
$frm_id_local = ($_POST['frm_id_local']<>''?$_POST['frm_id_local']:$_SESSION['id_local']);

require_once('../include/library.php');
conecta_bd_cacic();
$where = ' AND loc.id_local ='.$frm_id_local;
if ($_SESSION['te_locais_secundarios'])
	{
	$where = str_replace('loc.id_local',' (loc.id_local',$where);
	$where .= ' OR (loc.id_local IN ('.$_SESSION['te_locais_secundarios'].'))) ';
	}

$queryConfiguracoesLocais = "	SELECT 			loc.id_local,
												loc.sg_local,
												loc.nm_local,
												c_loc.in_exibe_erros_criticos,
												c_loc.in_exibe_bandeja,
												c_loc.nu_exec_apos,
												c_loc.dt_hr_coleta_forcada,																			 												
												c_loc.nu_intervalo_exec,
												c_loc.te_senha_adm_agente,												
												c_loc.te_serv_updates_padrao,												
												c_loc.te_serv_cacic_padrao,																																				
												c_loc.te_enderecos_mac_invalidos,																																																
												c_loc.te_janelas_excecao																																																												
								FROM 			locais loc,
												configuracoes_locais c_loc
								WHERE 			loc.id_local = c_loc.id_local ";
$orderby = ' ORDER BY loc.sg_local';

$resultConfiguracoesLocais = mysql_query($queryConfiguracoesLocais.$where.$orderby) or die('1-Select Imposs�vel nas tabelas Locais/Configuracoes_Locais ou sua sess�o expirou!');
$row_configuracoes_locais = mysql_fetch_array($resultConfiguracoesLocais);
if ($_SESSION['cs_nivel_administracao'] == 1 || $_SESSION['cs_nivel_administracao'] == 2 || ($_SESSION['cs_nivel_administracao'] == 3 && $_SESSION['te_locais_secundarios']<>''))
	{	
	?>
	<div id="LayerLocais" style="position:absolute; width:200px; height:115px; z-index:1; left: 0px; top: 0px; visibility:hidden">
	<?

	$resultConfiguracoesLocais = mysql_query($queryConfiguracoesLocais.$orderby) or die('2-Select Imposs�vel nas tabelas Locais/Configuracoes_Locais ou sua sess�o expirou!');

	echo '<select name="SELECTconfiguracoes_locais">';
	while ($rowConfiguracoesLocais = mysql_fetch_array($resultConfiguracoesLocais))
		{
		echo '<option id="'.$rowConfiguracoesLocais['id_local'].'" value="'. $rowConfiguracoesLocais['in_exibe_bandeja'].'#'.
																			 $rowConfiguracoesLocais['in_exibe_erros_criticos'].'#'.
																			 $rowConfiguracoesLocais['te_senha_adm_agente'].'#'.																			 
																			 $rowConfiguracoesLocais['nu_exec_apos'].'#'.
																			 $rowConfiguracoesLocais['nu_intervalo_exec'].'#'.																			 
																			 $rowConfiguracoesLocais['te_enderecos_mac_invalidos'].'#'.																			 
																			 $rowConfiguracoesLocais['te_janelas_excecao'].'#'.																			 
																			 $rowConfiguracoesLocais['te_serv_updates_padrao'].'#'.
																			 $rowConfiguracoesLocais['te_serv_cacic_padrao'].'#'.
																			 $rowConfiguracoesLocais['dt_hr_coleta_forcada'].'">'.$rowConfiguracoesLocais['nm_local'].'</option>';							
		}
	echo '</select>';		
	?>
	</div>
	<?
	}
	?>

<script language="JavaScript" type="text/javascript" src="../include/cacic.js"></script>
<script language="JavaScript" type="text/javascript" src="../include/setLocalConfigAgentes.js"></script>
<form action="config_agentes_set.php"  method="post" ENCTYPE="multipart/form-data" name="forma">
<table width="90%" border="0" align="center">
  <tr> 
      <td class="cabecalho">Configura&ccedil;&otilde;es 
        dos M&oacute;dulos Agentes</td>
  </tr>
  <tr> 
    <td class="descricao">As op&ccedil;&otilde;es 
      abaixo determinam qual ser&aacute; o comportamento dos agentes oper&aacute;rios 
      do CACIC.</td>
  </tr>
</table>
  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="1">
  	<? 

	// Ser� mostrado apenas para os n�veis Administra��o, Gest�o Central e Supervis�o com acessos a locais secund�rios.
	if ($_SESSION['cs_nivel_administracao'] == 1 || $_SESSION['cs_nivel_administracao'] == 2 || ($_SESSION['cs_nivel_administracao'] == 3 && $_SESSION['te_locais_secundarios']<>''))
		{
		?>
	    <tr> 
	    <td class="label"><br>Locais: </td>
    	</tr>  
    	<tr> 
      	<td height="1" bgcolor="#333333"></td>
    	</tr>
    	<tr> 	
		<td>
		<?
		if ($_SESSION['cs_nivel_administracao'] == 1 || $_SESSION['cs_nivel_administracao'] == 2)
			$where = '';

    	conecta_bd_cacic();
		//$where = ($_SESSION['cs_nivel_administracao'] == 3 && $_SESSION['te_locais_secundarios']<>''?' WHERE loc.id_local IN ('.$_SESSION['te_locais_secundarios'].') ':'');		
		$query_locais = "SELECT		loc.id_local,
									loc.nm_local,
									loc.sg_local
					  	FROM		locais loc 
						WHERE 		1 ".
						$where . " 
				  		ORDER BY  	loc.sg_local"; 
		$result_locais = mysql_query($query_locais) or die('3-Ocorreu um erro durante a consulta � tabela de Locais ou sua sess�o expirou!'); 

		?>
    	<select size="5" name="SELECTlocais"  class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" onChange="setLocal(this);">	
    	<? 		
		while ($row_locais = mysql_fetch_array($result_locais))
			{
			echo '<option id="'.$row_locais['id_local'].'" value="'. $row_locais['id_local'].'"';
			if ($row_locais['id_local']==$frm_id_local) 
				echo '  selected="selected"';
			
			echo '>'.$row_locais['sg_local'].' - '.$row_locais['nm_local'].'</option>';					
			}
 		?> 
    	</select>
		</td>
    	</tr>
		<?
		}
		?>
  
    <tr> 
      <td class="label">

        <? 

	// Comentado temporariamente - AntiSpy();
    conecta_bd_cacic();
	$query = "SELECT 	in_exibe_bandeja, 
						in_exibe_erros_criticos, 
						nu_exec_apos, 
						nu_intervalo_exec, 
						te_senha_adm_agente, 
 	         			DATE_FORMAT(dt_hr_coleta_forcada, '%d/%m/%Y �s %H:%i') as dt_hr_coleta_forcada, 
						te_enderecos_mac_invalidos, 
						te_janelas_excecao
	          FROM 		configuracoes_locais 
			  WHERE		id_local = ".$frm_id_local." 
			  			limit 1"; 						 


	$result_configuracoes = mysql_query($query) or die('4-Ocorreu um erro durante a consulta � tabela de configura��es ou sua sess�o expirou!'); 
	$campos_configuracoes = mysql_fetch_array($result_configuracoes);
?>
        &nbsp;<br>
        Exibir o &iacute;cone do CACIC na bandeja do Windows (systray):</td>
    </tr>
    <tr> 
      <td height="1" bgcolor="#333333"></td>
    </tr>
    <tr> 
      <td class="opcao"><p><input name="in_exibe_bandeja" type="radio" value="S"  <? if (strtoupper($campos_configuracoes['in_exibe_bandeja']) == 'S') echo 'checked'; ?>  class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >
          Sim<br>
          <input type="radio" name="in_exibe_bandeja" value="N" <? if (strtoupper($campos_configuracoes['in_exibe_bandeja']) == 'N') echo 'checked'; ?>  class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >
          <input name="frm_id_local" id="frm_id_local" type="hidden" value="<? echo $frm_id_local; ?>">		  		  
          N&atilde;o<br></p></td>
    </tr>
    <tr> 
      <td class="label">&nbsp;&nbsp; <br>
        Exibir erros cr&iacute;ticos aos usu&aacute;rios: </td>
    </tr>
    <tr> 
      <td height="1" bgcolor="#333333"></td>
    </tr>
    <tr> 
      <td class="opcao"><p><input name="in_exibe_erros_criticos" type="radio" value="S"  <? if (strtoupper($campos_configuracoes['in_exibe_erros_criticos']) == 'S') echo 'checked'; ?>  class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >
           Sim<br>
          <input type="radio" name="in_exibe_erros_criticos" value="N" <? if (strtoupper($campos_configuracoes['in_exibe_erros_criticos']) == 'N') echo 'checked'; ?>  class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >
          N&atilde;o<br>
          </p></td>
    </tr>
    <tr> 
      <td class="label">&nbsp;&nbsp; <br>
        Senha usada para configurar e finalizar os agentes: </td>
    </tr>
    <tr> 
      <td height="1" bgcolor="#333333"></td>
    </tr>
    <tr> 
      <td><p>
          <input name="te_senha_adm_agente" type="password"  value="<? echo $campos_configuracoes['te_senha_adm_agente']; ?>" maxlength="30" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >
          <br></p></td>
    </tr>
    <tr> 
      <td class="label">&nbsp;<br>Inicio de execu&ccedil;&atilde;o das a&ccedil;&otilde;es: </td>
    </tr>
    <tr> 
      <td height="1" bgcolor="#333333"></td>
    </tr>
    <tr> 
      <td class="opcao"> <p>
          <input name="nu_exec_apos" type="radio" value="0" <? if ($campos_configuracoes['nu_exec_apos'] == '0') echo 'checked'; ?>  class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >
          Imediatamente ap&oacute;s a inicializa&ccedil;&atilde;o do CACIC<br>
          <input type="radio" name="nu_exec_apos" value="10"  <? if ($campos_configuracoes['nu_exec_apos'] == '10') echo 'checked'; ?>  class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >
          10 minutos ap&oacute;s a inicializa&ccedil;&atilde;o do CACIC<br>
          <input name="nu_exec_apos" type="radio" value="20"  <? if ($campos_configuracoes['nu_exec_apos'] == '20') echo 'checked'; ?>  class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >
          20 minutos ap&oacute;s a inicializa&ccedil;&atilde;o do CACIC<br>
          <input type="radio" name="nu_exec_apos" value="30"  <? if ($campos_configuracoes['nu_exec_apos'] == '30') echo 'checked'; ?>  class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >
          30 minutos ap&oacute;s a inicializa&ccedil;&atilde;o do CACIC<br>
          <input type="radio" name="nu_exec_apos" value="60"  <? if ($campos_configuracoes['nu_exec_apos'] == '60') echo 'checked'; ?>  class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >
          1 hora ap&oacute;s a inicializa&ccedil;&atilde;o do CACIC<br>
          </p></td>
    </tr>
    <tr> 
      <td class="label">&nbsp;<br>Intervalo de execu&ccedil;&atilde;o das a&ccedil;&otilde;es:</td>
    </tr>
    <tr> 
      <td height="1" bgcolor="#333333"></td>
    </tr>
    <tr> 
      <td class="opcao"><p> 
          <input type="radio" name="nu_intervalo_exec" value="2"   <? if ($campos_configuracoes['nu_intervalo_exec'] == '2') echo 'checked'; ?>  class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >
          A cada 2 horas <br>
           
          <input type="radio" name="nu_intervalo_exec" value="4" <? if ($campos_configuracoes['nu_intervalo_exec'] == '4') echo 'checked'; ?>  class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >
          A cada 4 horas <br>
           
          <input type="radio" name="nu_intervalo_exec" value="6"  <? if ($campos_configuracoes['nu_intervalo_exec'] == '6') echo 'checked'; ?> class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >
          A cada 6 horas  <br>
           
          <input type="radio" name="nu_intervalo_exec" value="8"  <? if ($campos_configuracoes['nu_intervalo_exec'] == '8') echo 'checked'; ?> class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >
          A cada 8 horas  <br>
           
          <input type="radio" name="nu_intervalo_exec" value="10"  <? if ($campos_configuracoes['nu_intervalo_exec'] == '10') echo 'checked'; ?>  class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >
          A cada 10 horas  <br>
          </p></td>

    </tr>
    <tr> 
      <td>&nbsp;</td>
    </tr>

	<tr> 	
    <td class="label">Op&ccedil;&otilde;es avan&ccedil;adas:</td>
    </tr>
    <tr> 
    <td height="1" bgcolor="#333333"></td>
    </tr>

    <tr> 
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td class="label"> <p><u>Endere&ccedil;os MAC a desconsiderar</u><br></p></td>
    </tr>
    <tr> 
      <td class="ajuda">Esta op&ccedil;&atilde;o tem por finalidade informar aos agentes coletores de informa&ccedil;&otilde;es 
          de TCP/IP acerca de endere&ccedil;os MAC inv&aacute;lidos, ou seja, 
          os endere&ccedil;os utilizados como padr&otilde;es em protocolos e/ou 
          dispositivos diferentes de TCP/Ethernet. Os coletores considerar&atilde;o 
          apenas os endere&ccedil;os MAC diferentes ou que n&atilde;o contenham 
          as informa&ccedil;&otilde;es aqui cadastradas, podendo ser partes de 
          endere&ccedil;os.</td>
    </tr>
	
    <tr> 
      <td height="1" bgcolor="#333333"></td>
    </tr>
    <tr> 
      <td><p><textarea name="te_enderecos_mac_invalidos" cols="60" id="te_enderecos_mac_invalidos" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" ><? echo $campos_configuracoes['te_enderecos_mac_invalidos']; ?></textarea>
          </p></td>
    </tr>
    <tr> 
      <td class="descricao">Aten&ccedil;&atilde;o: 
        informe os endere&ccedil;os separados por v&iacute;rgulas (&quot;,&quot;). 
        <br>
        Exemplo: &quot;00-53-45-00-00-00,00-00-00-00-00-00,44-45-53-54-00-00,44-45-53-54-00-01,28-41-53&quot;</td>
    </tr>

    <tr> 
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td class="label"> <p><u>Aplicativos (janelas) a evitar</u><br></p>
        </td>
    </tr>
    <tr> 
      <td class="descricao">Esta op&ccedil;&atilde;o tem por finalidade evitar que o Gerente de Coletas seja acionado enquanto 
          tais aplicativos (janelas) estiverem ativos.</td>
    </tr>
	
    <tr> 
      <td height="1" bgcolor="#333333"></td>
    </tr>
    <tr> 
      <td><p><textarea name="te_janelas_excecao" cols="60" id="te_janelas_excecao" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" ><? echo $campos_configuracoes['te_janelas_excecao']; ?></textarea>
          </p></td>
    </tr>
    <tr> 
      <td class="descricao">Aten&ccedil;&atilde;o: 
        informe os nomes separados por v&iacute;rgulas (&quot;,&quot;). <br>
        Exemplo: &quot;HOD, Microsoft Word, Corel Draw, PhotoShop&quot;</td>
    </tr>
	
    <?
	require_once('../include/opcoes_avancadas.php');
	?>
  </table>
  <tr> 
      	<td height="1" bgcolor="#333333"></td>
    	</tr>
    	<tr> 
      	<td>&nbsp;</td>
    	</tr>
    	<tr> 
      	<td><div align="center"> 
        <input name="submit" type="submit" value="  Gravar Informa&ccedil;&otilde;es  " onClick="return SelectAll_Forca_Coleta();return Confirma('Confirma Configura��o de Agentes?');" <? echo ($_SESSION['cs_nivel_administracao']<>1&&$_SESSION['cs_nivel_administracao']<>3?'disabled':'')?>>
        </div></td>
    	</tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>

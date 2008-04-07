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

// Comentado temporariamente - AntiSpy();
if ($_REQUEST['ExecutaUpdates']=='Executar Updates')
	{				
	// Enviarei tamb�m ao updates_subredes.php uma rela��o de agentes e vers�es para inser��o na tabela redes_versoes_modulos, no caso da ocorr�ncia de Servidor de Updates verificado anteriormente.
	// Exemplo de estrutura de agentes_versoes: col_soft.exe#22010103*col_undi.exe#22010103
	$v_agentes_versoes = '';
	foreach($HTTP_POST_VARS as $i => $v) 
		{
		//echo 'v: '.$v.'   i: '.$i.'<br>';
		if ($v && substr($i,0,7)=='update_' && $v <> 'on')
			{
			// O envio de versoes_agentes.ini deve ser incondicional!
			if ($v_updates == '') $v_updates = 'versoes_agentes.ini';
			
			if ($v_updates <> '') $v_updates .= '__';
			$v_updates .= $v;		
			}
		if ($v && substr($i,0,6)=='redes_' && $v <> 'on')
			{
			if ($v_redes <> '') $v_redes .= '__';			
			$v_redes .= $v;

			if ($v_force_redes <> '') $v_force_redes .= ',';						
			$v_force_redes .= '_fr_'.$v.'_fr_';
			}			

		// Verifico se a vers�o foi FOR�ADA ao update.
		if ($v && substr($i,0,6)=='force_' && $v <> 'on')
			{
			// O envio de versoes_agentes.ini deve ser incondicional!
			if ($v_force_modulos == '') $v_force_modulos = '_fm_versoes_agentes.ini_fm_';
			
			if ($v_force_modulos <> '') 
				{
				$v_force_modulos .= ",";			
				}
			$v_force_modulos .= '_fm_'.$v.'_fm_';		
			}								

		if ($v && substr($i,0,15)=='agentes_versoes')
			{
			$v_agentes_versoes = '_-_'.$v;
			}						
		}
		
	//echo 'v_updates: '.$v_updates.'<br><br>';
	//echo 'v_redes: '.$v_redes.'<br><br>';
	//echo 'v_force_modulos: '.$v_force_modulos.'<br><br>';

	// O tratamento de v_force_modulos foi transferido para updates_subredes.php

	// O script updates_subredes.php espera receber o par�metro v_parametros contendo uma string com a seguinte forma��o:
	// objeto1__objeto2__objetoN_-_rede1__rede2__rede3__redeN  
	// Onde: __  = Separador de itens
	//       _-_ = Separador de Matrizes		
        header ("Location: updates_subredes.php?v_parametros=".$v_updates.'_-_'.$v_redes.'_-_'.$v_force_modulos.$v_agentes_versoes);			
	}
else
	{
	?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
	<html>
	<head>
<link rel="stylesheet"   type="text/css" href="../../include/cacic.css">
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<? require_once('../../include/opcoes_avancadas_combos.js');  ?>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
function verificar()
	{
	var formRedes = window.document.forma;
	for (j=0;j<formRedes.elements.length;j++)
		if (formRedes.elements[j].type == 'checkbox' && formRedes.elements[j].id == 'redes' && formRedes[j].checked == true)
			return true;

	alert('ATEN��O: � necess�rio selecionar ao menos uma subrede!');
	return false;
	}
</script>

</head>
	
	<body background="../../imgs/linha_v.gif">
<script language="JavaScript" type="text/javascript" src="../../include/cacic.js"></script>					
	<table width="90%" border="0" align="center">
	  <tr> 
		<td class="cabecalho">Updates de SubRedes</td>
	  </tr>
	  <tr> 
		
    <td class="descricao">As informa&ccedil;&otilde;es referem-se aos objetos 
      constantes do reposit&oacute;rio, os quais poder&atilde;o ser assinalados 
      para verifica&ccedil;&atilde;o de exist&ecirc;ncia e/ou vers&otilde;es nas 
      SubRedes cadastradas.</td>
	  </tr>
	</table>
	
	<form method="post" ENCTYPE="multipart/form-data" name="forma" onSubmit="return verificar();">
	<script>
	function MarcaIncondicional(field,p_name) 
	{
	for (i = 1; i < field.length; i++) 
		if (field[i].type == 'checkbox' && field[i].name == p_name)
			field[i].checked = true;			

	return true;
	}

	</script>

  <div align="center">
    <table width="90%" border="0" align="center" cellpadding="0" cellspacing="1">
      <?
		$v_classe = "label";
		?>
      <tr> 
        <td height="20"></td>
      </tr>
	  
      <tr> 
        <td nowrap align="center" colspan="5" class="<? echo $v_classe; ?>"><br>
          Conte�do do Reposit&oacute;rio:</td>
      </tr>
      <tr> 
        <td colspan="5" height="1" bgcolor="#333333"></td>
      </tr>
      <tr> 
        <td class="destaque" align="center" colspan="3" valign="middle"><input name="update_subredes" id="update_subredes" type="checkbox" onClick="MarcaDesmarcaTodos(this.form.update_subredes),MarcaIncondicional(this.form.update_subredes,'update_subredes_versoes_agentes.ini'),MarcaIncondicional(this.form.update_subredes,'force_update_subredes_versoes_agentes.ini');">  
          &nbsp;&nbsp;Marca/Desmarca todos os objetos
		  </td>
      </tr>
      <tr> 
        <td nowrap colspan="2">&nbsp;</td>
      </tr>
      <tr> 
        <td nowrap colspan="2"><table border="1" align="center" cellpadding="2" bordercolor="#999999">
            <tr bgcolor="#FFFFCC"> 
              <td bgcolor="#EBEBEB" align="center"><img src="../../imgs/checked.gif" border="no"></td>
              <td bgcolor="#EBEBEB" class="cabecalho_tabela">Arquivo</td>
              <td bgcolor="#EBEBEB" class="cabecalho_tabela">Tamanho(KB)</td>
              <td align="center" colspan="3" nowrap bgcolor="#EBEBEB" class="cabecalho_tabela">Vers&atilde;o</td>
			  <td align="center" nowrap bgcolor="#EBEBEB" class="cabecalho_tabela">For&ccedil;ar</td>			  
            </tr>
            <? 
	  if ($handle = opendir('../../repositorio')) 
		{
		$v_nomes_arquivos = array();		
		while (false !== ($v_arquivo = readdir($handle))) 
			{
			if (substr($v_arquivo,0,1) != "." and 
			    $v_arquivo != "netlogon" and 
				$v_arquivo != "supergerentes" and 
				$v_arquivo != "chkcacic.exe" and
				$v_arquivo != "vaca.exe") // Versoes Agentes Creator/Atualizator //and 				
				//$v_arquivo != "versoes_agentes.ini") 		
				{
				// Armazeno o nome do arquivo
				array_push($v_nomes_arquivos, $v_arquivo);
				}
			}

		if (file_exists('../../repositorio/versoes_agentes.ini'))
			{
			$v_array_versoes_agentes = parse_ini_file('../../repositorio/versoes_agentes.ini');
			}

		sort($v_nomes_arquivos,SORT_STRING);
		$v_agentes_versoes = ''; // Conter� as vers�es dos agentes para tratamento em updates_subredes.php
		for ($cnt_arquivos = 0; $cnt_arquivos < count($v_nomes_arquivos); $cnt_arquivos++)
			{
			$v_dados_arquivo = lstat('../../repositorio/'.$v_nomes_arquivos[$cnt_arquivos]);
			echo '<tr>';
			echo '<td><input name="update_subredes_'.$v_nomes_arquivos[$cnt_arquivos].'" id="update_subredes" type="checkbox" class="normal" onBlur="SetaClassNormal(this);" value="'.$v_nomes_arquivos[$cnt_arquivos].'"';
			if ($v_nomes_arquivos[$cnt_arquivos] == 'versoes_agentes.ini') echo ' checked disabled'; // Implementar o OnChange para impedir o Marca/Desmarca todos para este campo...
			echo ' ></td>';
			echo '<td>'.$v_nomes_arquivos[$cnt_arquivos].'</td>';										
//			echo '<td align="right">'.number_format(($v_dados_arquivo[7]/1024), 1, '', '.').'</td>';			
			// Adequa��o ao resultado no Debian Etch
			echo '<td align="right">'.number_format(($v_dados_arquivo[7]/10240), 1, '', '.').'</td>';						
			if (isset($v_array_versoes_agentes) && $versao_agente = $v_array_versoes_agentes[$v_nomes_arquivos[$cnt_arquivos]])
				{
				echo '<td align="center" colspan="3">'.$versao_agente.'</td>';																
				}
			else
				{
				$versao_agente = strftime("%d/%m/%Y  %H:%Mh", $v_dados_arquivo[9]);
				echo '<td align="center" colspan="3">'.$versao_agente.'</td>';							
				}
			$v_agentes_versoes .= ($v_agentes_versoes<>''?'#':'');
			$v_agentes_versoes .= $v_nomes_arquivos[$cnt_arquivos].'*'.$versao_agente;	
			echo '<td align="center"><input name="force_update_subredes_'.$v_nomes_arquivos[$cnt_arquivos].'" id="force_update_subredes" type="checkbox" class="normal" onBlur="SetaClassNormal(this);" value="'.$v_nomes_arquivos[$cnt_arquivos].'"';
			if ($v_nomes_arquivos[$cnt_arquivos] == 'versoes_agentes.ini') echo ' checked disabled';
			echo '></td></tr>';											
			}
		echo '<input name="agentes_versoes" id="agentes_versoes" type="hidden" value="'.$v_agentes_versoes.'">';

		}
	 ?>
          </table></td>

      </tr>
    </table>
    <br>
  </div>
  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="1">
		<?
		$v_classe = "label";
		?>
		<tr> 
		  <td nowrap align="center" colspan="3" class="<? echo $v_classe; ?>"><br>
        SubRedes Cadastradas:</td>
		</tr>
		<tr> 
		  <td colspan="3" height="1" bgcolor="#333333"></td>
		</tr>
			  <tr> 
				<td class="destaque" align="center" colspan="3" valign="middle"><input name="redes" type="checkbox" id="redes" onClick="MarcaDesmarcaTodos(this.form.redes);">
        &nbsp;&nbsp;Marca/Desmarca todas as SubRedes</td>
			  </tr>
			  <tr><td height="10">&nbsp;</td></tr>
		
		<tr> 
		  <td nowrap colspan="3"><table border="1" align="center" cellpadding="2" bordercolor="#999999">
			  <tr bgcolor="#FFFFCC"> 
	            <td bgcolor="#EBEBEB" class="cabecalho_tabela">Seq.</td>			
				<td bgcolor="#EBEBEB" align="center"><img src="../../imgs/checked.gif" border="no"></td>				
				<td bgcolor="#EBEBEB" class="cabecalho_tabela">IP</td>
				
            <td bgcolor="#EBEBEB" class="cabecalho_tabela">Nome da Subrede</td>			
				<td bgcolor="#EBEBEB" class="cabecalho_tabela">Serv. de Updates</td>							
				<td bgcolor="#EBEBEB" class="cabecalho_tabela">Path</td>											
				<td bgcolor="#EBEBEB" class="cabecalho_tabela">Localiza��o</td>											
			  </tr>
			  
			  <? 
	   	 	  $where = ($_SESSION['cs_nivel_administracao']<>1&&$_SESSION['cs_nivel_administracao']<>2?' AND loc.id_local = '.$_SESSION['id_local']:'');
				if ($_SESSION['te_locais_secundarios']<>'' && $where <> '')
					{
					// Fa�o uma inser��o de "(" para ajuste da l�gica para consulta	
					$where = str_replace(' loc.id_local = ',' (loc.id_local = ',$where);
					$where .= ' OR loc.id_local in ('.$_SESSION['te_locais_secundarios'].')) ';
					}
			  
			  $query = "	SELECT 		re.id_ip_rede,
										re.nm_rede,
										loc.id_local,
										loc.sg_local,
										re.te_serv_updates,
										re.te_path_serv_updates
							FROM 		redes re,
										locais loc
							WHERE		re.id_local = loc.id_local ".
										$where ."
							GROUP BY    re.id_ip_rede
							ORDER BY	loc.sg_local,
										re.nm_rede"; 
				Conecta_bd_cacic();
				$result_redes = mysql_query($query) or die('Ocorreu um erro durante a consulta � tabela de redes ou sua sess�o expirou!'); 										
		$intSequencial = 1;
		while ($row = mysql_fetch_array($result_redes))
			{
			?>
			<tr>
			<td class="normal" align="right"><? echo $intSequencial;?></td>									
			<td><input name="redes_<? echo $row['id_ip_rede'];?>" id="redes" type="checkbox" class="normal" onBlur="SetaClassNormal(this);" value="<? echo $row['id_ip_rede'];?>"></td>
			<td class="normal"><? echo $row['id_ip_rede'];?></td>
			<td class="normal"><? echo $row['nm_rede'];?></td>
			<td class="normal"><? echo $row['te_serv_updates'];?></td>
			<td class="normal"><? echo $row['te_path_serv_updates'];?></td>
			<td class="normal"><? echo $row['sg_local'];?></td>
			</tr>
			<?
			$intSequencial ++;							
			}
	?> 
	</table></td>
	</tr>
	</table>        
	<p align="center">
	<br>
	<input name="ExecutaUpdates" type="submit" id="ExecutaUpdates" value="Executar Updates"  onClick="return Confirma('Confirma Verifica��o/Atualiza��o de SubRedes?'); MostraEscondeLayer('layerUpdatesSubredes');" <? echo ($_SESSION['cs_nivel_administracao']<>1&&$_SESSION['cs_nivel_administracao']<>3?'disabled':'')?>>
	
	</p>
	</form>		  			
	</body>
	</html>
	<?
	}
	?>
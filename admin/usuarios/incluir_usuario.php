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

include_once "../../include/library.php";

// Comentado temporariamente - AntiSpy();
Conecta_bd_cacic();

if($submit) 
	{	
	$frm_nm_usuario_acesso = $_POST['frm_nm_usuario_acesso'];  	
	$query = "SELECT 	* 
			  FROM 		usuarios 
			  WHERE 	nm_usuario_acesso = '$frm_nm_usuario_acesso'";
	$result = mysql_query($query) or die ('Falha na consulta � tabela Usu�rios ou sua sess�o expirou!');
	
	if (mysql_num_rows($result) > 0) 
		{
		header ("Location: ../../include/registro_ja_existente.php?chamador=../admin/usuarios/index.php&tempo=1");									 												
		}
	else 
		{
		$query = "INSERT 
				  INTO 		usuarios
				  			(nm_usuario_acesso, 
							 nm_usuario_completo, 
							 te_senha,  
							 dt_log_in, 
							 id_grupo_usuarios,
							 id_local,
							 te_emails_contato,
							 te_telefones_contato,
							 te_locais_secundarios) 
				  VALUES 	('$frm_nm_usuario_acesso', 
				  			'$frm_nm_usuario_completo', 
				  		  	PASSWORD('$frm_nm_usuario_acesso'), now(),
							'$frm_id_grupo_usuarios',
							'$frm_id_local',
							'$frm_te_emails_contato',
							'$frm_te_telefones_contato',
							'$frm_te_locais_secundarios')";
		$result = mysql_query($query) or die ('Insert falhou ou sua sess�o expirou!');
		GravaLog('INS',$_SERVER['SCRIPT_NAME'],'usuarios');		
		header ("Location: ../../include/operacao_ok.php?chamador=../admin/usuarios/index.php&tempo=1");									 											
		}
	?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
	<html>
	<?
	}
else 
	{
	?>
	<head>
	<link rel="stylesheet"   type="text/css" href="../../include/cacic.css">
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	
	<SCRIPT LANGUAGE="JavaScript">
	function SetaDescGrupo(p_descricao,p_destino) 
		{
		document.forms[0].elements[p_destino].value = p_descricao;		
		}
			
	function valida_form() 
		{
		if (document.form.frm_id_local.selectedIndex==0) 
			{	
			alert("O local do usu�rio � obrigat�rio");
			document.form.frm_id_local.focus();
			return false;
			}
	
		if (document.form.frm_nm_usuario_acesso.value == "" ) 
			{	
			alert("A identifica��o do usu�rio � obrigat�ria");
			document.form.frm_nm_usuario_acesso.focus();
			return false;
			}
		if (document.form.frm_nm_usuario_completo.value == "" ) 
			{	
			alert("O nome completo do usu�rio � obrigat�rio");
			document.form.frm_nm_usuario_completo.focus();
			return false;
			}
	
		if (document.form.frm_sel_id_locais_secundarios.value != "" ) 
			{
			var intLoop;
			var strIdLocaisSecundarios;
			
			strIdLocaisSecundarios = "";
			
			for (intLoop = 0; intLoop < document.form.frm_sel_id_locais_secundarios.options.length; intLoop++)
				{
				if (document.form.frm_sel_id_locais_secundarios.options[intLoop].selected)
					{
					if (strIdLocaisSecundarios != "")
						strIdLocaisSecundarios += ",";
						
					strIdLocaisSecundarios += document.form.frm_sel_id_locais_secundarios.options[intLoop].value;
					}
				}
			document.form.frm_te_locais_secundarios.value = strIdLocaisSecundarios;
			}		
		return true;
		}
	team = new Array(
	<?
	$sql='select * from locais ';
	$where = '';
	if ($_SESSION['te_locais_secundarios']<>'')
		{
		$where = ' where id_local = '.$_SESSION['id_local'].' OR id_local in ('.$_SESSION['te_locais_secundarios'].') ';
		}
	$sql .= $where . ' order by nm_local'; 

	conecta_bd_cacic();

	$sql_result=mysql_query($sql); 
	$num=mysql_numrows($sql_result); 
	$contador = 0;
	while ($row=mysql_fetch_array($sql_result))
		{ 
		$contador ++;
		if ($contador > 1)
			echo ",\n";
	
		$v_id_local=$row["id_local"]; 
		$v_sg_local=$row["sg_local"] . ' / '.$row["nm_local"]; 
		echo "new Array(\"$v_id_local\", \"$v_sg_local\")"; 
		} 
	echo ");\n"; 	
	?> 
	
	function fillSelectFromArray(selectCtrl, itemArray, itemAtual) 
		{ 	
		var i, j; 
		selectCtrl.disabled = true;			
		// empty existing items 
		for (i = selectCtrl.options.length; i >= 0; i--) 
			{ 
			selectCtrl.options[i] = null; 
			} 
	
		if (itemArray != null && itemAtual != 0) 
			{ 
			selectCtrl.size = 5;
			selectCtrl.disabled = false;			
			j = 1;
			// add new items 
			selectCtrl.options[0] = new Option("","          "); 		

			for (i = 0; i < itemArray.length; i++) 
				{ 
				if (itemArray[i][0] != itemAtual)
					{
					selectCtrl.options[j] = new Option(itemArray[i][0]); 
					if (itemArray[i][0] != null) 
						{ 
						selectCtrl.options[j].value = itemArray[i][0]; 					
						selectCtrl.options[j].text = itemArray[i][1]; 										
						} 
					j++; 
					}				
				} 
			// select first item (prompt) for sub list 
			selectCtrl.options[0].selected = true; 
		   } 
		}
	
	</script>
	</head>
	
	<body background="../../imgs/linha_v.gif" onLoad="SetaCampo('frm_id_local')">
	<script language="JavaScript" type="text/javascript" src="../../include/cacic.js"></script>
	<table width="90%" border="0" align="center">
	  <tr> 
		<td class="cabecalho"><div align="left">Inclus&atilde;o 
			de novo usu&aacute;rio</div></td>
	  </tr>
	  <tr> 
		<td class="descricao">As informa&ccedil;&otilde;es 
		  que dever&atilde;o ser cadastradas abaixo referem-se aos usu&aacute;rios 
		  do sistema, onde ser&aacute; determinado o tipo de acesso. <u><em>A senha 
		  inicial ser&aacute; gerada automaticamente em fun&ccedil;&atilde;o da identifica&ccedil;&atilde;o 
		  e poder&aacute; ser trocada pelo usu&aacute;rio na op&ccedil;&atilde;o Acesso/Troca 
		  de Senha no menu principal</em></u>. Ap&oacute;s o logon, ser&atilde;o exibidas 
		  a primeira e &uacute;ltima parte do campo Nome Completo.</td>
	  </tr>
	</table>
	<?
	$where = ($_SESSION['cs_nivel_administracao']<>1?' WHERE id_local = '.$_SESSION['id_local']:'');
	if (trim($_SESSION['te_locais_secundarios'])<>'' && $where <> '')
		{
		// Fa�o uma inser��o de "(" para ajuste da l�gica para consulta
		$where = str_replace('id_local = ','(id_local = ',$where);
		$where .= ' OR id_local IN ('.$_SESSION['te_locais_secundarios'].'))';	
		}

	$qry_local = "SELECT 		id_local, 
									sg_local,
									nm_local 
						FROM 		locais ".
									$where . "
						ORDER BY	sg_local";
	
	$result_local = mysql_query($qry_local) or die ('Falha na consulta � tabela Locais ou sua sess�o expirou!');
	?>
	
	  <p>&nbsp;</p><form action="incluir_usuario.php"  method="post" ENCTYPE="multipart/form-data" name="form" onSubmit="return valida_form()">
	  <table border="0" align="center" cellpadding="2" cellspacing="2">
		<tr> 
		  <td class="label">Local Prim&aacute;rio:</td>
		  <td><select name="frm_id_local" id="frm_id_local" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" onChange="fillSelectFromArray(this.form.frm_sel_id_locais_secundarios, team,this.form.frm_id_local.value);" <? echo ($_SESSION['cs_nivel_administracao']<>1 && ($_SESSION['cs_nivel_administracao']<>3 && !$_SESSION['cs_nivel_administracao'])?"disabled":"");?>>
			  <?
				echo '<option value="0">Selecione Local</option>';		  
				while($row = mysql_fetch_row($result_local))
					{
					echo '<option value="'.$row[0].'"';
					echo ($_SESSION['cs_nivel_administracao']<>1?" selected ":"");
					echo '>'.$row[1].' / '.$row[2].'</option>';
					}
					?>
			</select> 
			<?
			// Se n�o for n�vel Administrador ent�o fixa o id_local...
			if ($_SESSION['cs_nivel_administracao']<>1 && ($_SESSION['cs_nivel_administracao']<>3 && !$_SESSION['cs_nivel_administracao']))
				echo '<input name="frm_id_local" type="hidden" id="frm_id_local" value="'.$_SESSION['id_local'].'">';		
			?>
		  </td>
		</tr>
		<tr valign="top"> 
		  <td align="left" valign="top" nowrap class="label"><div align="left">Locais 
			  Secund&aacute;rios:</div></td>
		  <td>
	<select name="frm_sel_id_locais_secundarios" id="frm_sel_id_locais_secundarios" multiple disabled size="5" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" <? echo ($_SESSION['cs_nivel_administracao']<>1?"disabled":"");?>>
			  <option value=""></option>
			</select>
			<input name="frm_te_locais_secundarios" type="hidden" id="frm_te_locais_secundarios">		
			<br>
			<font color="#000080" size="1">(Dica: use SHIFT ou CTRL para selecionar 
			m&uacute;ltiplos itens)</font></td>
		</tr>
		<tr>
		  <td class="label">&nbsp;</td>
		  <td>&nbsp;</td>
		</tr>
		<tr> 
		  <td class="label">Identifica&ccedil;&atilde;o:</td>
		  <td> <input name="frm_nm_usuario_acesso" type="text" id="frm_nm_usuario_acesso" size="15" maxlength="15" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" > 
			&nbsp;&nbsp;<strong>Ex: </strong>d308951</td>
		</tr>
		<tr> 
		  <td class="label">Nome Completo:</td>
		  <td><input name="frm_nm_usuario_completo" type="text" id="frm_nm_usuario_completo" size="50" maxlength="100" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" ></td>
		</tr>
		<?
		$where = ($_SESSION['cs_nivel_administracao']<>1?' WHERE cs_nivel_administracao > '.$_SESSION['cs_nivel_administracao'].' OR cs_nivel_administracao=0':'');
		$qry_grp_usu = "SELECT 		id_grupo_usuarios, 
									te_grupo_usuarios, 
									te_descricao_grupo 
						FROM 		grupo_usuarios ".
									$where . "
						ORDER BY	te_grupo_usuarios";
		$result_qry_grp = mysql_query($qry_grp_usu) or die ('Falha na consulta � tabela Grupo_Usuarios ou sua sess�o expirou!');
	?>
		<tr nowrap> 
		  <td class="label">Emails para Contato:</td>
		  <td><input name="frm_te_emails_contato" type="text" id="frm_te_emails_contato" size="50" maxlength="100" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" ></td>
		</tr>
		<tr nowrap> 
		  <td class="label">Telefones para Contato:</td>
		  <td><input name="frm_te_telefones_contato" type="text" id="frm_te_telefones_contato" size="50" maxlength="100" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" ></td>
		</tr>
		<tr nowrap> 
		  <td class="label">Tipo de Acesso:</td>
		  <td> <select name="frm_id_grupo_usuarios" id="frm_id_grupo_usuarios" onChange="SetaDescGrupo(this.options[selectedIndex].id,'frm_te_descricao_grupo')" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >
			  <?
				while($row = mysql_fetch_row($result_qry_grp))
					{
					if (!$v_te_descricao_grupo) $v_te_descricao_grupo = $row[2]; 				
					echo '<option value="'.$row[0].'" id="'.$row[2].'">'.$row[1].'</option>';
					}
					?>
			</select></td>
		</tr>
		<tr nowrap> 
		  <td class="label">Descri&ccedil;&atilde;o de Acesso:</td>
		  <td><textarea name="frm_te_descricao_grupo" cols="50" rows="4" id="frm_te_descricao_grupo" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" ><? echo $v_te_descricao_grupo;?></textarea></td>
		</tr>
	  </table>
	  <p align="center"> <br>
		<br>
		<input name="submit" type="submit" value="  Gravar Informa&ccedil;&otilde;es  " onClick="return Confirma('Confirma Inclus�o de Usu�rio?');">
	  </p>
	</form>
	<p>
	<?
	}
?>
</p>
</body>
</html>

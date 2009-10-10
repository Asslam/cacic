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
  die('Acesso restrito (Restricted access)!');
else { // Inserir regras para outras verifica��es (ex: permiss�es do usu�rio)!
}

include_once "../../include/library.php";

AntiSpy('1,2,3'); // Permitido somente a estes cs_nivel_administracao...
// 1 - Administra��o
// 2 - Gest�o Central
// 3 - Supervis�o

if($_POST['submit']) 
	{
	Conecta_bd_cacic();
	
	$query = "SELECT 	* 
			  FROM 		redes 
			  WHERE 	id_ip_rede = '".$_POST['frm_id_ip_rede']."' AND
			  			id_local = ".$_POST['frm_id_local'];
						
	$result = mysql_query($query) or die ($oTranslator->_('falha na consulta a tabela (%1) ou sua sessao expirou!',array('redes')));
	
	if (mysql_num_rows($result) > 0) 
		{
		header ("Location: ../../include/registro_ja_existente.php?chamador=../admin/redes/index.php&tempo=1");									 							
		}
	else 
		{
		$query = "INSERT 
				  INTO 		redes 
				  			(id_ip_rede, 
							te_mascara_rede, 
							nm_rede, 
							te_observacao, 
							nm_pessoa_contato1, 
							nm_pessoa_contato2, 
				   			nu_telefone1, 
							nu_telefone2, 
							te_email_contato1, 
							te_email_contato2, 
							te_serv_cacic, 
							te_serv_updates, 
							nu_limite_ftp,
							te_path_serv_updates, 
							nm_usuario_login_serv_updates, 
							te_senha_login_serv_updates, 
							nm_usuario_login_serv_updates_gerente, 
							te_senha_login_serv_updates_gerente, 
							nu_porta_serv_updates,
							id_servidor_autenticacao, 
							id_local) 							
				 VALUES 	('".$_POST['frm_id_ip_rede']."',
				  		  	 '".$_POST['frm_te_mascara_rede']."',
						  	 '".$_POST['frm_nm_rede']."',
				  		  	 '".$_POST['frm_te_observacao']."', 						  
				  		  	 '".$_POST['frm_nm_pessoa_contato1']."', 
							 '".$_POST['frm_nm_pessoa_contato2']."', 
						  	 '".$_POST['frm_nu_telefone1']."',  
							 '".$_POST['frm_nu_telefone2']."', 
							 '".$_POST['frm_te_email_contato1']."', 
						  	 '".$_POST['frm_te_email_contato2']."',
						  	 '".$_POST['frm_te_serv_cacic']."',
						  	 '".$_POST['frm_te_serv_updates']."',
							  ".$_POST['frm_nu_limite_ftp'].",
						  	 '".$_POST['frm_te_path_serv_updates']."',						  
						  	 '".$_POST['frm_nm_usuario_login_serv_updates']."',
						  	 '".$_POST['frm_te_senha_login_serv_updates']."',
						  	 '".$_POST['frm_nm_usuario_login_serv_updates_gerente']."',
						  	 '".$_POST['frm_te_senha_login_serv_updates_gerente']."',			  
						  	 '".$_POST['frm_nu_porta_serv_updates']."',
							  ".$_POST['frm_id_servidor_autenticacao'].",								  
							  ".$_POST['frm_id_local'].")";									  							

		$result = mysql_query($query) or die ($oTranslator->_('Falha na insercao em (%1) ou sua sessao expirou!',array('redes')));
		GravaLog('INS',$_SERVER['SCRIPT_NAME'],'redes');

		$v_tripa_acoes = '';
		conecta_bd_cacic();

		$query_del = "DELETE 
					  FROM		acoes_redes 
					  WHERE		id_ip_rede = '".$_POST['frm_id_ip_rede']."' AND
								id_local = ".$_POST['frm_id_local'];
		mysql_query($query_del) or die($oTranslator->_('Falha em exclusao na tabela (%1) ou sua sessao expirou!',array('acoes_redes')));			
		GravaLog('DEL',$_SERVER['SCRIPT_NAME'],'acoes_redes');

		$v_cs_situacao = ($_POST['in_habilita_acoes'] == 'S'?'S':'N');

		$query_acoes = "SELECT 	* 
						FROM 	acoes";
		$result_acoes = mysql_query($query_acoes) or die($oTranslator->_('Falha na insercao em (%1) ou sua sessao expirou!',array('acoes'))); 
					
		while ($row_acoes = mysql_fetch_array($result_acoes))
			{
			if ($v_tripa_acoes <> '')
				{
				$v_tripa_acoes .= '#';
				}
			$v_tripa_acoes .= $row_acoes['id_acao'];
			$query_ins = "INSERT 
						  INTO 		acoes_redes 
									(id_ip_rede, 
									id_acao, 
									id_local,
									cs_situacao) 
						  VALUES	('".$_POST['frm_id_ip_rede']."', 
									'".$row_acoes['id_acao']."',
									".$_POST['frm_id_local'].",
									'".$v_cs_situacao."')";
			mysql_query($query_ins) or die($oTranslator->_('Falha na insercao em (%1) ou sua sessao expirou!',array('acoes_redes')));
			
			}						
			
		GravaLog('INS',$_SERVER['SCRIPT_NAME'],'acoes_redes');							
		$v_perfis = '';
		foreach($HTTP_POST_VARS as $i => $v) 
			{
			if ($v && substr($i,0,14)=='id_aplicativo_')
				{
				if ($v_perfis <> '') $v_perfis .= '__';
				$v_perfis .= $v;		
				}
			}

		seta_perfis_rede($_POST['frm_id_local'],$_POST['frm_id_ip_rede'], $v_perfis); 			
		update_subredes($_POST['frm_id_ip_rede'],'', '*' ,$_POST['frm_id_local']); 		

		?>
	 	<SCRIPT LANGUAGE="Javascript">
	    	location = '../../include/operacao_ok.php?chamador=../admin/redes/index.php&tempo=2';
	 	</script>
		<?
		
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
<?php initJSTranslateConst();?>
<script language=JavaScript>
<!--

function desabilitar()
	{
    return false
	}
document.oncontextmenu=desabilitar

// -->
</script>

<SCRIPT LANGUAGE="JavaScript">
function SetaServidorBancoDados()	
	{
	document.form.frm_te_serv_cacic.value = document.form.sel_te_serv_cacic.value;	
	document.form.sel_te_serv_cacic.options.selectedIndex=0;		
	}
function SetaServidorUpdates()	
	{
	var v_string = document.form.sel_te_serv_updates.value;
	var v_array_string = v_string.split("#");
	document.form.frm_te_serv_updates.value = v_array_string[0];
	document.form.frm_nu_porta_serv_updates.value = v_array_string[1];	
	document.form.frm_nm_usuario_login_serv_updates.value = v_array_string[2];		
	document.form.frm_nm_usuario_login_serv_updates_gerente.value = v_array_string[2];			
	document.form.frm_te_path_serv_updates.value = v_array_string[3];				
	document.form.frm_nu_limite_ftp.value = (v_array_string[4]==""?"30":v_array_string[4])
	document.form.sel_te_serv_updates.options.selectedIndex=0;
	document.form.frm_te_senha_login_serv_updates.value = "";
	document.form.frm_te_senha_login_serv_updates_gerente.value = "";	
	var v_campo_senha = document.form.document.frm_te_senha_login_serv_updates;
	v_campo_senha.document.write('<div style="background-color:#000099;"</div>');
	v_campo_senha.document.close();
	var v_campo_senha_gerente = document.form.document.frm_te_senha_login_serv_updates_gerente;
	v_campo_senha_gerente.document.write('<div style="background-color:#000099;"</div>');
	v_campo_senha_gerente.document.close();
	
	document.form.frm_te_senha_login_serv_updates.select();
	}

function valida_form(frmForm) 
	{
	if ( document.form.frm_nu_limite_ftp.value == "" ) 
		{	
		document.form.frm_nu_limite_ftp.value = "30";
		}					
	
	if (document.form.frm_id_local.selectedIndex==0) {	
		alert("<?=$oTranslator->_('O local da rede e obrigatorio')?>");
		document.form.frm_id_local.focus();
		return false;
	}

	if( !VerRedeMascara(frmForm.form.name,true,false)) {
	   return false;	
	}
		
	if ( document.form.frm_nm_rede.value == "" ) 
		{	
		alert("<?=$oTranslator->_('O nome da rede e obrigatorio')?>");
		document.form.frm_nm_rede.focus();
		return false;
		}
	else if ( document.form.frm_te_serv_cacic.value == "" ) 
		{	
		alert("<?=$oTranslator->_('Identificador do servidor de aplicacao e obrigatorio')?>");
		document.form.frm_te_serv_cacic.focus();
		return false;
		}	
	else if ( document.form.frm_te_serv_updates.value == "" ) 
		{	
		alert("<?=$oTranslator->_('Identificador do servidor de atualizacoes e obrigatorio')?>");
		document.form.frm_te_serv_updates.focus();
		return false;
		}		
	else if ( document.form.frm_nu_porta_serv_updates.value == "" ) 
		{	
		alert("<?=$oTranslator->_('Informe porta FTP do servidor de atualizacoes')?>");
		document.form.frm_nu_porta_serv_updates.focus();
		return false;
		}		
	else if ( document.form.frm_te_path_serv_updates.value == "" ) 
		{	
		alert("<?=$oTranslator->_('Informe o caminho FTP no servidor de atualizacoes')?>");
		document.form.frm_te_path_serv_updates.focus();
		return false;
		}			
	else if ( document.form.frm_nm_usuario_login_serv_updates.value == "" ) 
		{	
		alert("<?=$oTranslator->_('Informe o usuario de acesso FTP ao servidor de atualizacoes pelo agente de coletas')?>");
		document.form.frm_nm_usuario_login_serv_updates.focus();
		return false;
		}			
	else if ( document.form.frm_te_senha_login_serv_updates.value == "" ) 
		{	
		alert("<?=$oTranslator->_('Informe a senha do usuario de acesso FTP ao servidor de atualizacoes pelo agente de coletas')?>");
		document.form.frm_te_senha_login_serv_updates.focus();
		return false;
		}				
	else if ( document.form.frm_nm_usuario_login_serv_updates_gerente.value == "" ) 
		{	
		alert("<?=$oTranslator->_('Informe o usuario de acesso FTP ao servidor de atualizacoes pelo gerente')?>");
		document.form.frm_nm_usuario_login_serv_updates_gerente.focus();
		return false;
		}		
	else if ( document.form.frm_te_senha_login_serv_updates_gerente.value == "" ) 
		{	
		alert("<?=$oTranslator->_('Informe a senha do usuario de acesso FTP ao servidor de atualizacoes pelo gerente')?>");
		document.form.frm_te_senha_login_serv_updates_gerente.focus();
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

<body background="../../imgs/linha_v.gif" onLoad="SetaCampo('frm_id_local')">
<script language="JavaScript" type="text/javascript" src="../../include/cacic.js"></script>
<table width="90%" border="0" align="center">
  <tr> 
    <td class="cabecalho"><?=$oTranslator->_('Inclusao de nova subrede')?></td>
  </tr>
  <tr> 
    <td class="descricao">
       <?=$oTranslator->_('Inclusao de nova subrede - texto de ajuda')?>
    </td>
  </tr>
</table>
<form action="incluir_rede.php"  method="post" ENCTYPE="multipart/form-data" name="form" id="form">
  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="1">
    <tr> 
		<td>&nbsp;</td>
      <td class="label"><?=$oTranslator->_('Local')?> <span class="necessario">*</span></td>
      <td class="label" colspan="2"><br>Servidor para Autentica&ccedil;&atilde;o:</td>
    </tr>
    <tr> 
      <td colspan="4" height="1" bgcolor="#333333"></td>
    </tr>
    <tr> 
	<td>&nbsp;</td>
      <td> <select name="frm_id_local" id="frm_id_local"  class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);">
          <?
			$where = ($_SESSION['cs_nivel_administracao']<>1?' WHERE id_local = '.$_SESSION['id_local']:'');
			if (trim($_SESSION['te_locais_secundarios'])<>'' && $where <> '')
				{
				// Fa�o uma inser��o de "(" para ajuste da l�gica para consulta
				$where = str_replace(' id_local = ','(id_local = ',$where);
				$where .= ' OR id_local in ('.$_SESSION['te_locais_secundarios'].')) ';
				}
			
			Conecta_bd_cacic();				
			$qry_locais = "SELECT 	id_local,
											sg_local 
								 FROM 		locais ".
								 			$where." 
								 ORDER BY	sg_local";

	    $result_locais = mysql_query($qry_locais) or die ($oTranslator->_('falha na consulta a tabela (%1) ou sua sessao expirou!',array('locais')));
		echo '<option value="0">'.$oTranslator->_('--- selecione ---').'</option>';		  				
		while ($row=mysql_fetch_array($result_locais))
			{ 
			echo "<option value=\"" . $row["id_local"] . "\"";			
			if ($row['id_local']==$_SESSION['id_local'])
				echo ($_SESSION['cs_nivel_administracao']<>1?" selected":"");
			echo ">" . $row["sg_local"] . "</option>";
		   	} 
			?>
        </select>
        </td>
      <td nowrap><select name="frm_id_servidor_autenticacao" id="frm_id_servidor_autenticacao" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >
          <option value="" selected></option>
          <?
			  
		$qry_servidor_autenticacao = "SELECT 		id_servidor_autenticacao, 
									nm_servidor_autenticacao
						FROM 		servidores_autenticacao
						ORDER BY	nm_servidor_autenticacao";

		$result_servidor_autenticacao = mysql_query($qry_servidor_autenticacao) or die ('Falha na consulta &agrave; tabela Servidores de Autentica��o ou sua sess&atilde;o expirou!');
			  
				while($row = mysql_fetch_array($result_servidor_autenticacao))
					echo '<option value="'.$row['id_servidor_autenticacao'].'">'.$row['nm_servidor_autenticacao'].'</option>';
					
					?>
        </select></td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
	<td>&nbsp;</td>
      <td class="label"><br><?=$oTranslator->_('Subrede')?> <span class="necessario">*</span></td>
      <td nowrap class="label"><br><?=$oTranslator->_('Mascara')?> <span class="necessario">*</span></td>
      <td nowrap class="label">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="4" height="1" bgcolor="#333333"></td>
    </tr>
    <tr> 
	<td>&nbsp;</td>
      <td><input name="frm_id_ip_rede" id="frm_id_ip_rede" type="text"  class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" size="16" maxlength="16" > 
        <font color="#000099" size="1">Ex.: 10.71.0.0</font></font></td>
      <td><input name="frm_te_mascara_rede" id="frm_te_mascara_rede" type="text" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="return VerRedeMascara(this.form.name,false,true);SetaClassNormal(this);" value="255.255.255.0" size="15" maxlength="15" > 
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
	<td>&nbsp;</td>
      <td class="label"><div align="left"><?=$oTranslator->_('Descricao')?> <span class="necessario">*</span></div></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="4" height="1" bgcolor="#333333"></td>
    </tr>
    <tr> 
		<td>&nbsp;</td>
      <td nowrap><input name="frm_nm_rede" type="text" id="frm_nm_rede" size="50" maxlength="100" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" ></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
	<td>&nbsp;</td>
      <td nowrap class="label"><br>
        <?=$oTranslator->_('Servidor de aplicacoes')?> <span class="necessario">*</span></td>
      <td>&nbsp;&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="4" height="1" bgcolor="#333333"></td>
    </tr>
    <tr> 
	<td>&nbsp;</td>
	<?
    	$sql = "select * from configuracoes_padrao";
    	$db_result = mysql_query($sql);
    	$cfgStdData = (!mysql_errno())?mysql_fetch_assoc($db_result):'';
	?>
      <td nowrap> <input name="frm_te_serv_cacic" type="text" id="frm_te_serv_cacic" size="16" maxlength="16" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" value="<?=$cfgStdData['te_serv_cacic_padrao']?>"> 
        <select name="sel_te_serv_cacic" id="sel_te_serv_cacic" onChange="SetaServidorBancoDados();" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >
          <option value=""><?=$oTranslator->_('--- selecione ---');?></option>
          <?
			Conecta_bd_cacic();
			$query = "SELECT DISTINCT 	configuracoes_locais.te_serv_cacic_padrao, 
										redes.te_serv_cacic
			          FROM   			redes LEFT JOIN configuracoes_locais on (configuracoes_locais.te_serv_cacic_padrao = redes.te_serv_cacic)
					  WHERE  			redes.id_local = ".$_SESSION['id_local'] . "  
					  ORDER  BY 		configuracoes_locais.te_serv_cacic_padrao";
			mysql_query($query);
		    $sql_result=mysql_query($query);			
		while ($row=mysql_fetch_array($sql_result))
			{ 
			echo "<option value=\"" . $row["te_serv_cacic"] . "\"";
			echo ">" . $row["te_serv_cacic"] . "</option>";
		   	} 			
			?>
        </select></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
	<td>&nbsp;</td>
      <td nowrap class="label">
          <br><?=$oTranslator->_('Servidor de atualizacoes (FTP)')?> <span class="necessario">*</span>
      </td>
      <td class="label">
          <br><?=$oTranslator->_('Porta')?> <span class="necessario">*</span>
      </td>
      <td valign="bottom" class="label">
         <br><?=$oTranslator->_('Limite FTP')?>
      </td>
    </tr>
    <tr> 
      <td colspan="4" height="1" bgcolor="#333333"></td>
    </tr>
    <tr> 
	<td>&nbsp;</td>
      <td nowrap><input name="frm_te_serv_updates" type="text" id="frm_te_serv_updates"  size="16" maxlength="16" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" value="<?=$cfgStdData['te_serv_updates_padrao']?>"> 
        <select name="sel_te_serv_updates" id="sel_te_serv_updates" onChange="SetaServidorUpdates();" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >
          <option value=""><?=$oTranslator->_('--- selecione ---');?></option>
          <?
			Conecta_bd_cacic();
			$query = "SELECT DISTINCT 	redes.te_serv_updates, 
										redes.te_path_serv_updates,
										redes.nm_usuario_login_serv_updates,
										redes.nu_porta_serv_updates
			          FROM   redes
					  WHERE  redes.id_local = ".$_SESSION['id_local'] ."  
					  ORDER  BY redes.te_serv_updates";
			mysql_query($query);
		    $sql_result=mysql_query($query);			
		while ($row=mysql_fetch_array($sql_result))
			{ 
			echo "<option value=\"" . 
			$row["te_serv_updates"] . '#' . 
			$row["nu_porta_serv_updates"] . '#' . 
			$row["nm_usuario_login_serv_updates"] . '#' . 			
			$row["te_path_serv_updates"] . '#' .									
			$row["nu_limite_ftp"] . "\"";												
			echo ">" . $row["te_serv_updates"] . "</option>";
		   	} 			
			?>
        </select></td>
      <td><input name="frm_nu_porta_serv_updates" type="text" class="normal" id="frm_nu_porta_serv_updates" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" value="21" size="15" maxlength="4" > 
      </td>
      <td><input name="frm_nu_limite_ftp" type="text" id="frm_nu_limite_ftp" size="5" maxlength="5" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" value="100"></td>
    </tr>
    <tr> 
	<td>&nbsp;</td>
      <td nowrap class="label">
        <br><?=$oTranslator->_('Usuario de acesso FTP ao servidor de atualizacoes pelo agente de coletas')?> <span class="necessario">*</span>
      </td>
      <td nowrap class="label">
          <br><?=$oTranslator->_('Senha de acesso')?> <span class="necessario">*</span>
      </td>
      <td nowrap class="label">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="4" height="1" bgcolor="#333333"></td>
    </tr>
    <tr> 
	<td>&nbsp;</td>
      <td nowrap> <input name="frm_nm_usuario_login_serv_updates" type="text" id="frm_nm_usuario_login_serv_updates" size="20" maxlength="20" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" > 
      </td>
      <td> <input name="frm_te_senha_login_serv_updates" type="password" id="frm_te_senha_login_serv_updates" size="15" maxlength="15" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" > 
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
	<td>&nbsp;</td>
      <td nowrap class="label">
        <br><?=$oTranslator->_('Usuario de acesso FTP ao servidor de atualizacoes pelo gerente')?> <span class="necessario">*</span>
      </td>
      <td nowrap class="label">
          <br><?=$oTranslator->_('Senha de acesso')?> <span class="necessario">*</span>
      </td>
      <td nowrap class="label">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="4" height="1" bgcolor="#333333"></td>
    </tr>
    <tr> 
	<td>&nbsp;</td>
      <td nowrap> <input name="frm_nm_usuario_login_serv_updates_gerente" type="text" id="frm_nm_usuario_login_serv_updates_gerente" size="20" maxlength="20" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" > 
      </td>
      <td> <input name="frm_te_senha_login_serv_updates_gerente" type="password" id="frm_te_senha_login_serv_updates_gerente" size="15" maxlength="15" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" > 
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
	<td>&nbsp;</td>
      <td nowrap class="label">
        <br><?=$oTranslator->_('Caminho (path) FTP no servidor de atualizacoes')?> <span class="necessario">*</span>
      </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="4" height="1" bgcolor="#333333"></td>
    </tr>
    <tr> 
	<td>&nbsp;</td>
      <td><input name="frm_te_path_serv_updates" type="text" id="frm_te_path_serv_updates" size="50" maxlength="100" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" ></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
	<td>&nbsp;</td>
      <td class="label"><br>
        <?=$oTranslator->_('Observacoes')?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="4" height="1" bgcolor="#333333"></td>
    </tr>
    <tr> 
	<td>&nbsp;</td>
      <td><textarea name="frm_te_observacao" cols="60" id="textarea" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" ></textarea></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
	<td>&nbsp;</td>
      <td class="label"><br>
        <?=$oTranslator->_('Contato um')?></td>
      <td width="144" class="label"><br>
        <?=$oTranslator->_('Telefone')?></td>
      <td class="label"><br><?=$oTranslator->_('Endereco eletronico')?></td>
    </tr>
    <tr> 
      <td colspan="4" height="1" bgcolor="#333333"></td>
    </tr>
    <tr> 
	<td>&nbsp;</td>
      <td> <input name="frm_nm_pessoa_contato1" type="text" id="frm_nm_pessoa_contato12" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" > 
      </td>
      <td> <input name="frm_nu_telefone1" type="text" id="frm_nu_telefone12" size="12" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" > 
      </td>
      <td>
          <input name="frm_te_email_contato1" type="text" id="frm_te_email_contato1" size="50" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >
      </td>
    </tr>
    <tr> 
	<td>&nbsp;</td>
      <td class="label"><br>
        </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="4" height="1" bgcolor="#333333"></td>
    </tr>
    <tr> 
	<td>&nbsp;</td>
      <td class="label"><br>
        <?=$oTranslator->_('Contato dois')?></td>
      <td width="144" class="label"><br>
        <?=$oTranslator->_('Telefone')?></td>
      <td class="label"><br><?=$oTranslator->_('Endereco eletronico')?></td>
    </tr>
    <tr> 
      <td colspan="4" height="1" bgcolor="#333333"></td>
    </tr>
    <tr> 
	<td>&nbsp;</td>
      <td> <input name="frm_nm_pessoa_contato2" type="text" id="frm_nm_pessoa_contato2" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" > 
      </td>
      <td> <input name="frm_nu_telefone2" type="text" id="frm_nu_telefone2" size="12" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" > 
      </td>
      <td>
           <input name="frm_te_email_contato2" type="text" id="frm_te_email_contato22" size="50" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >
      </td>
    </tr>
    <tr> 
	<td>&nbsp;</td>
      <td class="label"><br>
        </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="4" height="1" bgcolor="#333333"></td>
    </tr>
    <tr> 
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr> 
	<td>&nbsp;</td>
      <td colspan="3" class="label">
        <?=$oTranslator->_('Marcar todas as acoes para essa rede')?>
      </td>
    </tr>
    <tr> 
      <td colspan="4" height="1" bgcolor="#333333"></td>
    </tr>
    <tr> 
		<td>&nbsp;</td>
      <td colspan="3" class="descricao"><div align="justify">
         <?=$oTranslator->_('Marcar todas as acoes para essa rede - texto de ajuda')?>
          </div>
      </td>
    </tr>
    <tr> 
      <td colspan="4" height="1" bgcolor="#CCCCCC"></td>
    </tr>
    <tr> 
	<td>&nbsp;</td>
      <td>
        <input name="in_habilita_acoes" type="radio" value="S" checked class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >
        <?=$oTranslator->_('Sim')?>
        <br>
        <input type="radio" name="in_habilita_acoes" value="N" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >
        <?=$oTranslator->_('Nao')?>
      </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	<?
	include "../../include/opcoes_sistemas_monitorados.php";
	?>
  </table>
  <p align="center"> 
    <input name="submit" type="submit" value="<?=$oTranslator->_('Gravar informacoes')?>"  onClick="return valida_form(this);return Confirma('<?=$oTranslator->_('Confirma inclusao de rede?')?>');">
  </p>
</form>
<p>
  <?
}
?>
</p>
</body>
</html>

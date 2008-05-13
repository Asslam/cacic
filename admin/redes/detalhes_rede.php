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
require_once('../../include/library.php');

AntiSpy();
Conecta_bd_cacic();

if ($_REQUEST['ExcluiRede']) 
	{
	$query = "DELETE 
			  FROM 		redes 
			  WHERE 	id_ip_rede = '".$_REQUEST['id_ip_rede']."' AND
			  			id_local = ".$_REQUEST['id_local_anterior'];
	mysql_query($query) or die('1-Falha de dele��o na tabela redes ou sua sess�o expirou!');
	GravaLog('DEL',$_SERVER['SCRIPT_NAME'],'redes');				
	$query = "DELETE 	
			  FROM 		acoes_redes 
			  WHERE 	id_ip_rede = '".$_REQUEST['id_ip_rede']."' AND
			  			id_local = ".$_REQUEST['id_local_anterior'];
	mysql_query($query) or die('2-Falha de dele��o na tabela a��es_redes ou sua sess�o expirou!');	
	GravaLog('DEL',$_SERVER['SCRIPT_NAME'],'acoes_redes');				

	$query = "DELETE 	
			  FROM 		aplicativos_redes 
			  WHERE 	id_ip_rede = '".$_REQUEST['id_ip_rede']."' AND
			  			id_local = ".$_REQUEST['id_local_anterior'];
	mysql_query($query) or die('3-Falha de dele��o na tabela aplicativos_redes ou sua sess�o expirou!');	
	GravaLog('DEL',$_SERVER['SCRIPT_NAME'],'aplicativos_redes');				
	
	header ("Location: ../../include/operacao_ok.php?chamador=../admin/redes/index.php&tempo=1");									 				
	}
elseif ($_POST['GravaAlteracoes']) 
	{
	$boolJaExiste = false;
	if ($_POST['frm_id_local'] <> $_REQUEST['id_local_anterior'])
		{
		$query = "SELECT 	* 
				  FROM 		redes 
				  WHERE 	id_ip_rede = '".$_POST['id_ip_rede']."' AND
			  				id_local = ".$_POST['frm_id_local'];
						
		$result = mysql_query($query) or die ('Select falhou ou sua sess�o expirou!');
		if (mysql_num_rows($result) > 0) 		
			$boolJaExiste = true;
		}
	
	if ($boolJaExiste) 
		{
		header ("Location: ../../include/registro_ja_existente.php?chamador=../admin/redes/index.php&tempo=2");									 							
		}
	else
		{	
		$senhas = '';
		if ($_SESSION['te_senha_login_serv_updates'] <> $_POST['frm_te_senha_login_serv_updates'] && $_POST['frm_te_senha_login_serv_updates'] <> '**********')
			$senhas = ", te_senha_login_serv_updates = '".$_POST['frm_te_senha_login_serv_updates']."'";	
	
		if ($_SESSION['te_senha_login_serv_updates_gerente'] <> $_POST['frm_te_senha_login_serv_updates_gerente'] && $_POST['frm_te_senha_login_serv_updates_gerente'] <> '**********')
			$senhas .= ", te_senha_login_serv_updates_gerente = '".$_POST['frm_te_senha_login_serv_updates_gerente']."'";	
			
		$query = "UPDATE 	redes SET 
							te_mascara_rede 						= '".$_POST['frm_te_mascara_rede']."',
							nm_rede 								= '".$_POST['frm_nm_rede']."', 
							te_observacao 							= '".$_POST['frm_te_observacao']."', 
							nm_pessoa_contato1 						= '".$_POST['frm_nm_pessoa_contato1']."', 
							nm_pessoa_contato2 						= '".$_POST['frm_nm_pessoa_contato2']."', 
							nu_telefone1 							= '".$_POST['frm_nu_telefone1']."', 
							nu_telefone2 							= '".$_POST['frm_nu_telefone2']."', 
							te_email_contato1 						= '".$_POST['frm_te_email_contato1']."', 
							te_email_contato2 						= '".$_POST['frm_te_email_contato2']."', 
							te_serv_cacic 							= '".$_POST['frm_te_serv_cacic']."', 
							te_serv_updates 						= '".$_POST['frm_te_serv_updates']."', 
							nu_limite_ftp 							=  ".$_POST['frm_nu_limite_ftp'].", 						
							te_path_serv_updates 					= '".$_POST['frm_te_path_serv_updates']."',
							nm_usuario_login_serv_updates 			= '".$_POST['frm_nm_usuario_login_serv_updates']."', 
							nu_porta_serv_updates 					= '".$_POST['frm_nu_porta_serv_updates']."',
							nm_usuario_login_serv_updates_gerente 	= '".$_POST['frm_nm_usuario_login_serv_updates_gerente']."', 
							id_local 								=  ".$_POST['frm_id_local'].
							$senhas . " 
				  WHERE 	trim(id_ip_rede) = '".trim($_REQUEST['id_ip_rede'])."' AND
							id_local = ".$_REQUEST['id_local_anterior'];
	// Anderson Peterle - via VPN - 29/11/2007
	//if ($_SERVER['REMOTE_ADDR']=='10.71.0.58')
	//	echo $query.'<br>';
	
		mysql_query($query) or die('4-Falha na atualiza��o da tabela Redes ou sua sess�o expirou!');
		GravaLog('UPD',$_SERVER['SCRIPT_NAME'],'redes');
	
		$query = "UPDATE 	acoes_redes SET 
							id_local = ".$_POST['frm_id_local']."
				  WHERE 	trim(id_ip_rede) = '".trim($_REQUEST['id_ip_rede'])."' AND
							id_local = ".$_REQUEST['id_local_anterior'];					
		mysql_query($query) or die('5-Falha na atualiza��o da tabela Acoes_Redes ou sua sess�o expirou!');
		GravaLog('UPD',$_SERVER['SCRIPT_NAME'],'acoes_redes');			
	
		$query = "UPDATE 	redes_grupos_ftp SET 
							id_local =  ".$_POST['frm_id_local']."
				  WHERE 	trim(id_ip_rede) = '".trim($_REQUEST['id_ip_rede'])."' AND
							id_local = ".$_REQUEST['id_local_anterior'];
		mysql_query($query) or die('6-Falha na atualiza��o da tabela Redes_Grupos_FTP ou sua sess�o expirou!');
		GravaLog('UPD',$_SERVER['SCRIPT_NAME'],'redes_grupos_ftp');			
	
		$query = "UPDATE 	redes_versoes_modulos SET 
							id_local =  ".$_POST['frm_id_local']."
				  WHERE 	trim(id_ip_rede) = '".trim($_REQUEST['id_ip_rede'])."' AND
							id_local = ".$_REQUEST['id_local_anterior'];
		mysql_query($query) or die('7-Falha na atualiza��o da tabela Redes_Versoes_Modulos ou sua sess�o expirou!');
		GravaLog('UPD',$_SERVER['SCRIPT_NAME'],'redes_versoes_modulos');			
	
		// Caso tenha sido alterado o local da subrede, primeiramente atualizarei a informa��o abaixo:
		if ($_POST['frm_id_local'] <> $_POST['id_local'])
			{
			$query = "UPDATE 	aplicativos_redes SET 
								id_local =  ".$_POST['frm_id_local']."
					  WHERE 	trim(id_ip_rede) = '".trim($_REQUEST['id_ip_rede'])."' AND
								id_local = ".$_REQUEST['id_local_anterior'];
			mysql_query($query) or die('8-Falha na atualiza��o da tabela Aplicativos_Redes ou sua sess�o expirou!');
			GravaLog('UPD',$_SERVER['SCRIPT_NAME'],'aplicativos_Redes');			
			}
		
		$v_perfis = '';
		foreach($HTTP_POST_VARS as $i => $v) 
			{
			if ($v && substr($i,0,14)=='id_aplicativo_')
				{
				if ($v_perfis <> '') $v_perfis .= '__';
				$v_perfis .= $v;		
				}
			}
		if ($v_perfis <> '')
			{
			$query = "DELETE 	
					  FROM 		aplicativos_redes 
					  WHERE 	id_ip_rede = '".$_REQUEST['id_ip_rede']."' AND
								id_local = ".$_REQUEST['id_local_anterior'];
			mysql_query($query) or die('9-Falha de dele��o na tabela aplicativos_redes ou sua sess�o expirou!');	
			GravaLog('DEL',$_SERVER['SCRIPT_NAME'],'aplicativos_redes');						
			seta_perfis_rede($_REQUEST['frm_id_local'],trim($_REQUEST['id_ip_rede']), $v_perfis); 					
			}		
			
		header ("Location: ../../include/operacao_ok.php?chamador=../admin/redes/index.php&tempo=1");									 					
		}
	}
else 
	{
	$query = "	SELECT 	* 
				FROM 	redes						
				WHERE 	redes.id_ip_rede = '".$_GET['id_ip_rede']."' AND 
				        redes.id_local = ".$_GET['id_local'];		
	$result = mysql_query($query) or die ('10-Falha na consulta �s tabelas Redes, Locais ou sua sess�o expirou!');
	?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<link rel="stylesheet"   type="text/css" href="../../include/cacic.css">
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
	document.form.frm_nu_limite_ftp.value = (v_array_string[4]==""?"5":v_array_string[4]);					
	document.form.sel_te_serv_updates.options.selectedIndex=0;
	document.form.frm_te_senha_login_serv_updates.value = "";
	document.form.frm_te_senha_login_serv_updates_gerente.value = "";	
	document.form.frm_te_senha_login_serv_updates.select();
	}

function valida_form() 
	{	
	if ( document.form.frm_nu_limite_ftp.value == "" ) 
		{	
		document.form.frm_nu_limite_ftp.value = "5";
		}					
	
	if (document.form.frm_id_local.selectedIndex==0 && document.form.frm_id_local.value==-1) 
		{	
		alert("O local da rede � obrigat�rio");
		document.form.frm_id_local.focus();
		return false;
		}
		
	if ( document.form.frm_nm_rede.value == "" ) 
		{	
		alert("Digite o nome da rede");
		document.form.frm_nm_rede.focus();
		return false;
		}
	else if ( document.form.frm_te_serv_cacic.value == "" ) 
		{	
		alert("Digite o Identificador do Servidor de Banco de Dados");
		document.form.frm_te_serv_cacic.focus();
		return false;
		}	
	else if ( document.form.frm_te_serv_updates.value == "" ) 
		{	
		alert("Digite o Identificador do Servidor de Updates");
		document.form.frm_te_serv_updates.focus();
		return false;
		}		
	else if ( document.form.frm_nu_porta_serv_updates.value == "" ) 
		{	
		alert("Digite a Porta FTP do Servidor de Updates");
		document.form.frm_nu_porta_serv_updates.focus();
		return false;
		}		
	else if ( document.form.frm_nm_usuario_login_serv_updates.value == "" ) 
		{	
		alert("Digite o Nome do Usu�rio para Login no Servidor de Updates pelo M�dulo Agente");
		document.form.frm_nm_usuario_login_serv_updates.focus();
		return false;
		}		
	else if ( document.form.frm_nm_usuario_login_serv_updates_gerente.value == "" ) 
		{	
		alert("Digite o Nome do Usu�rio para Login no Servidor de Updates pelo M�dulo Gerente");
		document.form.frm_nm_usuario_login_serv_updates_gerente.focus();
		return false;
		}			
	else if ( document.form.frm_te_path_serv_updates.value == "" ) 
		{	
		alert("Digite o Path no Servidor de Updates");
		document.form.frm_te_path_serv_updates.focus();
		return false;
		}		
	return true;
	}
</script>
<style type="text/css">
<!--
.style4 {
	color: #FF0000;
	font-weight: bold;
}
.style5 {
	font-size: 7pt;
	color: #FF9900;
}
.style7 {color: #0000FF; font-weight: bold; }
.style9 {font-size: 7pt; color: #006600; }
-->
</style>
</head>
<?
$pos = substr_count($_SERVER['HTTP_REFERER'],'navegacao');
?>
<body <? if (!$pos) echo 'background="../../imgs/linha_v.gif"';?> onLoad="SetaCampo('<? echo ($_SESSION['cs_nivel_administracao']<>1?'frm_te_mascara_rede':'frm_id_local')?>')">
<script language="javascript" type="text/javascript" src="../../include/cacic.js"></script>
<form action="detalhes_rede.php"  method="post" ENCTYPE="multipart/form-data" name="form" id="form" onSubmit="return valida_form()">
<table width="90%" border="0" align="center">
  <tr> 
      <td class="cabecalho">Detalhes da Subrede <? echo mysql_result($result, 0, 'id_ip_rede'); ?></td>
  </tr>
  <tr> 
    <td class="descricao">As op&ccedil;&otilde;es 
      abaixo determinam qual ser&aacute; o comportamento dos agentes oper&aacute;rios 
      do CACIC.</td>
  </tr>
</table>

<table width="60%" border="0" align="center" cellpadding="5" cellspacing="1">
  <tr> 
    <td valign="top"> 

        <table width="90%" border="0" cellpadding="0" cellspacing="1">
          <tr> 
            <td>&nbsp;</td>
            <td class="label"><br>Local:</td>
            <td class="label" colspan="2">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="4" height="1" bgcolor="#333333"></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td> <select name="frm_id_local" id="frm_id_local"  class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);"  
			<?
			echo ($_SESSION['cs_nivel_administracao']<>1 && $_SESSION['cs_nivel_administracao']<>3?'disabled':'');
			?>
			>
                <?
			$qry_locais = "SELECT 	id_local,
									sg_local 
						   FROM 	locais 
						   ORDER BY	sg_local";

			if ($_SESSION['te_locais_secundarios']<>'')
				{
				// Fa�o uma inser��o de "(" para ajuste da l�gica para consulta
				$qry_locais = str_replace('locais','locais WHERE (locais.id_local = '.$_SESSION["id_local"].' OR locais.id_local in('.$_SESSION['te_locais_secundarios'].')) ',$qry_locais);
				}

		    $result_locais = mysql_query($qry_locais) or die ('11-Select falhou ou sua sess�o expirou!');
		if (mysql_result($result, 0, 'nm_local')=='')
			echo "<option value='-1' selected>Selecione Local</option>";
		$id_local_anterior = 0;							
		while ($row=mysql_fetch_array($result_locais))
			{ 
			echo "<option value=\"" . $row["id_local"] . "\"";
			if ($_GET['id_local'] == $row["id_local"])
				{
				$id_local_anterior = $row["id_local"];
				echo " selected";
				}
			echo ">" . $row["sg_local"] . "</option>";
		   	} 
			?>
              </select> 
			<?
			// Caso o usu�rio n�o seja privilegiado, o valor abaixo dever� ser fixado...
			//if ($_SESSION['cs_nivel_administracao']>1)
			//	echo '<input name="frm_id_local"  type="hidden" id="frm_id_local" value="'.$_GET['id_local'].'">'; 				
			?>
			  <input name="id_local_anterior"  type="hidden" id="id_local_anterior" value="<? echo $id_local_anterior; ?>">
			  <input name="id_local"  type="hidden" id="id_local" value="<? echo $_GET['id_local']; ?>">            </td>
            <td>&nbsp; </td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td class="label"><br>
              Subrede:</td>
            <td class="label"><br>
              M&aacute;scara:</td>
            <td class="label"><br>
            Abrang&ecirc;ncia:</td>
          </tr>
          <tr> 
            <td colspan="4" height="1" bgcolor="#333333"></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td> <input name="frm_id_ip_rede" id="frm_id_ip_rede" readonly="" type="text" value="<? echo mysql_result($result, 0, 'id_ip_rede'); ?>" size="16" maxlength="16" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" > 
              <input name="id_ip_rede"  type="hidden" id="id_ip_rede" value="<? echo mysql_result($result, 0, 'id_ip_rede'); ?>" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >            </td>
            <td> <input name="frm_te_mascara_rede" type="text" id="frm_te_mascara_rede" value="<? echo mysql_result($result, 0, 'te_mascara_rede'); ?>" size="15" maxlength="15" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="return VerRedeMascara(this.form.name,false,true);SetaClassNormal(this);" >            </td>
            <td nowrap="nowrap"><input name="frm_id_ip_inicio" id="frm_id_ip_inicio" disabled="disabled" type="text" class="normal">
								&nbsp;a&nbsp;
								<input name="frm_id_ip_fim" id="frm_id_ip_fim" disabled="disabled" type="text" class="normal">
			</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td class="label"><br>
              Descri&ccedil;&atilde;o:</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="4" height="1" bgcolor="#333333"></td>
          </tr>
          <tr> 
            <td nowrap>&nbsp;</td>
            <td nowrap><input name="frm_nm_rede" type="text" id="frm_nm_rede" value="<? echo mysql_result($result, 0, 'nm_rede'); ?>" size="50" maxlength="100" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >
			</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td nowrap>&nbsp;</td>
            <td nowrap class="label"><br>
              Servidor de Aplica&ccedil;&atilde;o:</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="4" height="1" bgcolor="#333333"></td>
          </tr>
          <tr> 
            <td rowspan="11" align="center" valign="middle" nowrap><font color="#000000"> 
              <? 
			$intStatusFTP_AGENTE = CheckFtpLogin(mysql_result($result, 0, 'te_serv_updates'),
    							  		  		 mysql_result($result, 0, 'nm_usuario_login_serv_updates'),
							  			  		 mysql_result($result, 0, 'te_senha_login_serv_updates'),
							  			  		 mysql_result($result, 0, 'nu_porta_serv_updates'));
			if ($intStatusFTP_AGENTE == 1)
				{
		  		$v_conexao_ftp_AGENTE = conecta_ftp(mysql_result($result, 0, 'te_serv_updates'),
				                      			    mysql_result($result, 0, 'nm_usuario_login_serv_updates'),
											 		mysql_result($result, 0, 'te_senha_login_serv_updates'),
											 		mysql_result($result, 0, 'nu_porta_serv_updates'),
													false
											       );
				}
			  
			$intStatusFTP_GERENTE = CheckFtpLogin(mysql_result($result, 0, 'te_serv_updates'),
    							  		  		  mysql_result($result, 0, 'nm_usuario_login_serv_updates_gerente'),
							  			  		  mysql_result($result, 0, 'te_senha_login_serv_updates_gerente'),
							  			  		  mysql_result($result, 0, 'nu_porta_serv_updates'));
			if ($intStatusFTP_GERENTE == 1)
				{
		  		$v_conexao_ftp_GERENTE = conecta_ftp(mysql_result($result, 0, 'te_serv_updates'),
				                      			     mysql_result($result, 0, 'nm_usuario_login_serv_updates_gerente'),
											 		 mysql_result($result, 0, 'te_senha_login_serv_updates_gerente'),
											 		 mysql_result($result, 0, 'nu_porta_serv_updates'),
													 false
											        );
				}
			// Como s�o 4 campos cr�ticos para a conex�o FTP, separo 2 conjuntos de vari�veis para classifica��o de erro
			$v_classe_campo_user_pass_AGENTE  = "normal";									
			$v_classe_campo_user_pass_GERENTE = "normal";							
			$v_classe_campo_path  			  = "normal";										
					
			if ($v_conexao_ftp_AGENTE && (@ftp_chdir($v_conexao_ftp_AGENTE,mysql_result($result, 0, 'te_path_serv_updates').'/')) &&
			    $v_conexao_ftp_GERENTE && (@ftp_chdir($v_conexao_ftp_GERENTE,mysql_result($result, 0, 'te_path_serv_updates').'/')))			
				{
				echo '<img src="../../imgs/ftp_conectado.gif" height="55" width="55">';
				?>
				<br>
              	</font><span class="style7">OK! </span><font color="#000000"><br>
              	</font><span class="style9">Sucesso<br>na Conex�o FTP!</span>
				<?							
				}
			else
				{
				echo '<img src="../../imgs/ftp_desconectado.gif" height="55" width="55">';

				if ($intStatusFTP_AGENTE <> 1)
					$v_classe_campo_user_pass_AGENTE = "anormal";												
				elseif (!@ftp_chdir($v_conexao_ftp_AGENTE,mysql_result($result, 0, 'te_path_serv_updates').'/'))					
					$v_classe_campo_path  			  = "anormal";														

				if ($intStatusFTP_GERENTE <> 1)
					$v_classe_campo_user_pass_GERENTE = "anormal";												
				elseif (!@ftp_chdir($v_conexao_ftp_GERENTE,mysql_result($result, 0, 'te_path_serv_updates').'/'))					
					$v_classe_campo_path  			  = "anormal";														
					
				?>
				<br>
              	</font><span class="style4">ATEN&Ccedil;&Atilde;O: </span><font color="#000000"><br>
              	</font><span class="style5">Verifique<br>
              	os campos<br>
              	destacados<br>
              	em amarelo</span>
				<?			
				}
		  ?>                          </font> <div align="center"></div></td>
            <td nowrap><input name="frm_te_serv_cacic" type="text" id="frm_te_serv_cacic" value="<? echo mysql_result($result, 0, 'te_serv_cacic'); ?>" size="16" maxlength="16" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" > 
              <select name="sel_te_serv_cacic" id="sel_te_serv_cacic" onChange="SetaServidorBancoDados();" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >
                <option value="">===> Selecione <===</option>
                <?
			Conecta_bd_cacic();
			$query = "SELECT DISTINCT 	configuracoes_locais.te_serv_cacic_padrao, 
										redes.te_serv_cacic
			          FROM   			redes LEFT JOIN configuracoes_locais on (configuracoes_locais.te_serv_cacic_padrao = redes.te_serv_cacic)
					  WHERE  			redes.id_local = ".$_REQUEST['id_local']." AND					  				     
					  					configuracoes_locais.id_local = redes.id_local
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
            <td class="label"><br>
              Servidor de Updates(FTP):</td>
            <td nowrap class="label"> <br>
              Porta:</td>
            <td nowrap class="label"><br>
			Limite FTP:</td>
          </tr>
          <tr> 
            <td colspan="3" height="1" bgcolor="#333333"></td>
          </tr>
          <tr> 
            <td nowrap> <input name="frm_te_serv_updates" type="text" id="frm_te_serv_updates" value="<? echo mysql_result($result, 0, 'te_serv_updates'); ?>" size="16" maxlength="16" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" > 
              <select name="sel_te_serv_updates" id="sel_te_serv_updates" onChange="SetaServidorUpdates();" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >
                <option value="">===> Selecione <===</option>
                <?
			Conecta_bd_cacic();
			$query = "SELECT DISTINCT 	redes.te_serv_updates, 
										redes.te_path_serv_updates,
										redes.nm_usuario_login_serv_updates,
										redes.nu_porta_serv_updates,
										redes.nu_limite_ftp
			          FROM   redes
					  WHERE  redes.id_local = ".$_REQUEST['id_local']. "  
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
            <td> <input name="frm_nu_porta_serv_updates" type="text" id="frm_nu_porta_serv_updates" value="<? echo mysql_result($result, 0, 'nu_porta_serv_updates'); ?>" size="15" maxlength="4" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >            </td>
            <td><input name="frm_nu_limite_ftp" type="text" id="frm_nu_limite_ftp" value="<? echo mysql_result($result, 0, 'nu_limite_ftp'); ?>" size="5" maxlength="5" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" ></td>
          </tr>
          <tr> 
            <td nowrap class="label"><br>
              Path no Servidor de Updates:</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="3" height="1" bgcolor="#333333"></td>
          </tr>
          <tr> 
            <td nowrap> <input name="frm_te_path_serv_updates" type="text" id="frm_te_path_serv_updates" value="<? echo mysql_result($result, 0, 'te_path_serv_updates'); ?>" size="50" maxlength="100" class="<? echo $v_classe_campo_path;?>" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td nowrap align="center" colspan="3" class="label"><br>
              Conte�do do Servidor de Updates:</td>
          </tr>
          <tr> 
            <td colspan="3" height="1" bgcolor="#333333"></td>
          </tr>
          <tr> 
            <td nowrap colspan="3"><table border="1" align="center" cellpadding="2" bordercolor="#999999"><font style="bold" size="1" face="Verdana">
                <tr bgcolor="#FFFFCC"> 
                  <td bgcolor="#EBEBEB">&nbsp;</td>
                  <td bgcolor="#EBEBEB" class="cabecalho_tabela">Arquivo</td>
                  <td bgcolor="#EBEBEB" class="cabecalho_tabela">Tamanho(KB)</td>
                  <td colspan="3" align="center" nowrap bgcolor="#EBEBEB" class="cabecalho_tabela">Vers&atilde;o</td>
                </tr>
                <? 
				if ($v_conexao_ftp_GERENTE)
					{
					
					echo lista_updates(mysql_result($result, 0, 'te_serv_updates'),
		 							   mysql_result($result, 0, 'nm_usuario_login_serv_updates_gerente'),
									   mysql_result($result, 0, 'te_senha_login_serv_updates_gerente'),
									   mysql_result($result, 0, 'nu_porta_serv_updates'),
									   mysql_result($result, 0, 'te_path_serv_updates').'/'); 
															  

				 
				 }?>
              </table></td>
          </tr>
          <tr> 
            <td nowrap class="label"> <br>
              Usu&aacute;rio do Servidor de Updates: (para AGENTE)</td>
            <td nowrap class="label"><br>
              Senha para Login:</td>
            <td nowrap class="label">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="4" height="1" bgcolor="#333333"></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td> <input name="frm_nm_usuario_login_serv_updates" type="text" id="frm_nm_usuario_login_serv_updates" value="<? echo mysql_result($result, 0, 'nm_usuario_login_serv_updates'); ?>"  size="20" maxlength="20" class="<? echo $v_classe_campo_user_pass_AGENTE;?>" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >            </td>
            <td> <input name="frm_te_senha_login_serv_updates" type="password" id="frm_te_senha_login_serv_updates" value="**********"  size="15" maxlength="15" class="<? echo $v_classe_campo_user_pass_AGENTE;?>" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" > 
			<?
			$_SESSION['te_senha_login_serv_updates'] = mysql_result($result, 0, 'te_senha_login_serv_updates'); 
			$_SESSION['te_senha_login_serv_updates_gerente'] = mysql_result($result, 0, 'te_senha_login_serv_updates_gerente'); 			
			?>            </td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td nowrap class="label"> <br>
              Usu&aacute;rio do Servidor de Updates: (para GERENTE)</td>
            <td nowrap class="label"><br>
              Senha para Login:</td>
            <td nowrap class="label">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="4" height="1" bgcolor="#333333"></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td> <input name="frm_nm_usuario_login_serv_updates_gerente" type="text" id="frm_nm_usuario_login_serv_updates_gerente" value="<? echo mysql_result($result, 0, 'nm_usuario_login_serv_updates_gerente'); ?>"  size="20" maxlength="20" class="<? echo $v_classe_campo_user_pass_GERENTE;?>" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >            </td>
            <td> <input name="frm_te_senha_login_serv_updates_gerente" type="password" id="frm_te_senha_login_serv_updates_gerente" value="**********"  size="15" maxlength="15" class="<? echo $v_classe_campo_user_pass_GERENTE;?>" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >            </td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td class="label"><br>
              Observa&ccedil;&otilde;es:</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="4" height="1" bgcolor="#333333"></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><textarea name="frm_te_observacao" cols="38" id="textarea"  class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" ><? echo mysql_result($result, 0, 'te_observacao'); ?></textarea></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td class="label"><br>
              Contato 1:</td>
            <td class="label"><br>
              Telefone:</td>
            <td class="label">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="4" height="1" bgcolor="#333333"></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td> <input name="frm_nm_pessoa_contato1" type="text" id="frm_nm_pessoa_contato12" value="<? echo mysql_result($result, 0, 'nm_pessoa_contato1'); ?>" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >            </td>
            <td> <input name="frm_nu_telefone1" type="text" id="frm_nu_telefone12" value="<? echo mysql_result($result, 0, 'nu_telefone1'); ?>" size="12" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >            </td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td class="label"><br>
              E-mail:</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="4" height="1" bgcolor="#333333"></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td> <input name="frm_te_email_contato1" type="text" id="frm_te_email_contato12" value="<? echo mysql_result($result, 0, 'te_email_contato1'); ?>" size="50" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td class="label"><br>
              Contato 2:</td>
            <td class="label"><br>
              Telefone:</td>
            <td class="label">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="4" height="1" bgcolor="#333333"></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td> <input name="frm_nm_pessoa_contato2" type="text" id="frm_nm_pessoa_contato2" value="<? echo mysql_result($result, 0, 'nm_pessoa_contato2'); ?>" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >            </td>
            <td> <input name="frm_nu_telefone2" type="text" id="frm_nu_telefone22" value="<? echo mysql_result($result, 0, 'nu_telefone2'); ?>" size="12" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >            </td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td class="label"><br>
              E-mail:</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="4" height="1" bgcolor="#333333"></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td> <input name="frm_te_email_contato2" type="text" id="frm_te_email_contato2" value="<? echo mysql_result($result, 0, 'te_email_contato2'); ?>" size="50" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="4">&nbsp;</td>
          </tr>
          <?		  
		$query_acoes_redes = "	SELECT	te_descricao_breve 
								FROM 	acoes,
										acoes_redes ac_re 
								WHERE 	acoes.id_acao = ac_re.id_acao and
										ac_re.id_ip_rede = '".$_REQUEST['id_ip_rede']."' AND
										ac_re.id_local = ".$_REQUEST['id_local'];
//echo $query_acoes_redes . '<br>';
		conecta_bd_cacic();
		$result_acoes_redes = mysql_query($query_acoes_redes);
		?>
          <tr> 
            <td>&nbsp;</td>
            <? 		
		if (mysql_num_rows($result_acoes_redes)>0)		
            echo '<td class="label"><br>A��es selecionadas para essa rede:</td>';
		else
			echo '<td class="label_vermelho"><br>Nenhuma a��o selecionada para essa rede!</td>';
		?>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td height="1" colspan="4" bgcolor="#333333"></td>
          </tr>
          <?
		
		$v_contador = 0;
		while ($row = mysql_fetch_array($result_acoes_redes))
			{
			$v_contador ++;
			?>
          <tr> 
            <td></td>
            <td colspan="3" nowrap class="descricao"> <? echo $v_contador . ')&nbsp;' . $row['te_descricao_breve']; ?>            </td>
          </tr>
          <?
			}
			?>
          <tr> 
            <td height="1" colspan="4" bgcolor="#333333"></td>
          </tr>
			<?
			include "../../include/opcoes_sistemas_monitorados.php";
			?>
		  
          <tr> 
            <td height="1" colspan="4" bgcolor="#333333"></td>
          </tr>
		  
		<?	
		if ($_POST['VerificaUpdates']) 
		{		  
		?>
          <table>
            <tr> 
              <td> 
                <?
			if ($_SESSION['v_efetua_conexao_ftp'] > 0)
				{	
				echo '<font color="#000099" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Verifica��o Efetuada!</strong></font>';
							
				if ($_SESSION['v_conta_objetos_atualizados'] > 0)
					{
					$v_array_objetos_atualizados = explode('#',$_SESSION['v_tripa_objetos_atualizados']);
					for ($cnt_objetos = 0; $cnt_objetos < $_SESSION['v_conta_objetos_atualizados']; $cnt_objetos++)
						{
						?>
            <tr> 
              <td valign="center" bgcolor="<? echo $v_cor_zebra;?>"> <p align="left">&nbsp; 
                </p></td>
              <td valign="center" bgcolor="<? echo $v_cor_zebra;?>"> <p align="left">&nbsp;</p></td>
              <td valign="center" bgcolor="<? echo $v_cor_zebra;?>"> <p align="left">&nbsp;</p></td>
              <td valign="center" bgcolor="<? echo $v_cor_zebra;?>"> <p align="left">&nbsp;</p></td>
              <td valign="center" bgcolor="<? echo $v_cor_zebra;?>"> <p align="left">Atualizando 
                  <? echo $v_array_objetos_atualizados[$cnt_objetos];?>... 
                  <?					
						}						
					}
				if ($_SESSION['v_conta_objetos_nao_atualizados'] > 0)
					{
					$v_array_objetos_nao_atualizados = explode('#',$_SESSION['v_tripa_objetos_nao_atualizados']);					
					for ($cnt_objetos = 0; $cnt_objetos < $_SESSION['v_conta_objetos_nao_atualizados']; $cnt_objetos++) 					
						{

						?>
            <tr> 
              <td valign="center" bgcolor="<? echo $v_cor_zebra;?>"> <p align="left">&nbsp;</p></td>
              <td valign="center" bgcolor="<? echo $v_cor_zebra;?>"> <p align="left">&nbsp;</p></td>
              <td valign="center" bgcolor="<? echo $v_cor_zebra;?>"> <p align="left">&nbsp;</p></td>
              <td valign="center" bgcolor="<? echo $v_cor_zebra;?>"> <p align="left">&nbsp;</p></td>
              <td valign="center" bgcolor="<? echo $v_cor_zebra;?>"> <p align="left">N�o 
                  Atualizado: <? echo $v_array_objetos_nao_atualizados[$cnt_objetos];?>! 
                  <?					
						}						
					}
				if ($_SESSION['v_conta_objetos_enviados'] > 0)
					{
					$v_array_objetos_enviados = explode('#',$_SESSION['v_tripa_objetos_enviados']);					
					for ($cnt_objetos = 0; $cnt_objetos < $_SESSION['v_conta_objetos_enviados']; $cnt_objetos++) 					
						{
						?>
            <tr> 
              <td valign="center" bgcolor="<? echo $v_cor_zebra;?>"> <p align="left">&nbsp;</p></td>
              <td valign="center" bgcolor="<? echo $v_cor_zebra;?>"> <p align="left">&nbsp;</p></td>
              <td valign="center" bgcolor="<? echo $v_cor_zebra;?>"> <p align="left">&nbsp;</p></td>
              <td valign="center" bgcolor="<? echo $v_cor_zebra;?>"> <p align="left">&nbsp;</p></td>
              <td valign="center" bgcolor="<? echo $v_cor_zebra;?>"> <p align="left">Enviando 
                  <? echo $v_array_objetos_enviados[$cnt_objetos];?>... 
                  <?					
						}						
					 }
				if ($_SESSION['v_conta_objetos_nao_enviados'] > 0)
					{
					$v_array_objetos_nao_enviados = explode('#',$_SESSION['v_tripa_objetos_nao_enviados']);					
					for ($cnt_objetos = 0; $cnt_objetos < $_SESSION['v_conta_objetos_nao_enviados']; $cnt_objetos++) 					
						{
						?>
            <tr> 
              <td valign="center" bgcolor="<? echo $v_cor_zebra;?>"> <p align="left">&nbsp;</p></td>
              <td valign="center" bgcolor="<? echo $v_cor_zebra;?>"> <p align="left">&nbsp;</p></td>
              <td valign="center" bgcolor="<? echo $v_cor_zebra;?>"> <p align="left">&nbsp;</p></td>
              <td valign="center" bgcolor="<? echo $v_cor_zebra;?>"> <p align="left">&nbsp;</p></td>
              <td valign="center" bgcolor="<? echo $v_cor_zebra;?>"> <p align="left">N�o 
                  Enviado <? echo $v_array_objetos_nao_enviados[$cnt_objetos];?>! 
                  <?					
						}						
					}										
				}									
			else if($_SESSION['v_status_conexao'] == 'NC')
				{
					echo '<font color="#FF0000" size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="redes/detalhes_rede.php?id_ip_rede='. $row['id_ip_rede'] .'" style="color: red"><strong>FTP n�o configurado!</strong></a></font>';					
				}
			else if($_SESSION['v_status_conexao'] == 'OFF')
				{
					echo '<font color="#FF0000" size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="redes/detalhes_rede.php?id_ip_rede='. $row['id_ip_rede'] .'" style="color: red"><strong>Servidor OffLine!</strong></a></font>';															
				}

		?>
              </td>
            </tr>
            <?
		}
		?>
          </table>
          <p align="center"> <br>
            <input name="GravaAlteracoes" type="submit" id="GravaAlteracoes" value="  Gravar Altera&ccedil;&otilde;es  " onClick="return Confirma('Confirma Informa��es para Esta Rede?'); " <? echo ($_SESSION['cs_nivel_administracao']<>1 && $_SESSION['cs_nivel_administracao']<>3?'disabled':'')?>>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
            <input name="ExcluiRede" type="submit" value="  Excluir Rede  " onClick="return Confirma('Confirma Exclus�o de Rede?');" <? echo ($_SESSION['cs_nivel_administracao']<>1 && $_SESSION['cs_nivel_administracao']<>3?'disabled':'')?>>
            <?
			if ($_REQUEST['nm_chamador']=='locais')
				{
				?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
            <input name="RetornaLocais" type="button" value="  Retorna aos Detalhes de Local  " onClick="history.back()">
            <?
				}
				?>
          </p>
        </table>  
</table>
<script language="javascript" type="text/javascript">
VerRedeMascara('form',true,false);
</script>

</form>
</body>
</html>
<?
}
?>

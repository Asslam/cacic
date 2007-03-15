<?php
/**
 * @version $Id: index.php 2007-02-08 22:20 harpiain $
 * @package Cacic-Installer
 * @subpackage Instalador
 * @author Adriano dos Santos Vieira <harpiain at gmail.com>
 * @copyright Copyright (C) 2007 Adriano dos Santos Vieira. All rights reserved.
 * @license GNU/GPL, see LICENSE.php
 * CACIC-Install is free software and parts of it may contain or be derived from the
 * GNU General Public License or other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// direct access is denied
defined( 'CACIC' ) or die( 'Acesso restrito (Restricted access)!' );

include_once("classes/install.tmpl.php");
include_once("classes/install.ado.php");

/**
 * Prove a Instala��o pela WEB
 */
class Install {
	
	/**
	 * Objeto de template
	 */
	var $oTmpl;
	
	/**
	 * Objeto AJAX
	 */
	var $oAjax;
	
	/**
	 * Objeto de persistencia
	 */
	var $oDB;
	
	/**
	 * Objeto tradutor
	 */
	var $oLang;
	
	/**
	 * Prove a Instala��o pela WEB
	 * @internal Construtor para a classe Install compatibilizado com PHP4
	 */
	 function Install() {
		$this->__construct();
	 }
	
	/**
	 * Prove a Instala��o pela WEB
	 * @internal Construtor para a classe Install compatibilizado com PHP5.
	 */
	 function __construct() {
    	if(isset($_POST['cacic_config']))
    	   $_SESSION['cacic_config'] = $_POST['cacic_config'];
    	
    	if(isset($_POST['cacic_admin']))
    	   $_SESSION['cacic_admin'] = $_POST['cacic_admin'];
	 
	 	/*
	 	 * instacia objetos de classes externas
	 	 */
	 	 $this->oTmpl = new Template();
	 	 $this->oTmpl->header();
	 	 $this->oTmpl->body();
	 }
	 
	 /**
	  * Mostra a barra de navega��o contextualizando o posso da instala��o
	  */
	 function navBar($showNavBar="preInstall") {
	 	 switch (strtolower($showNavBar)) {
	 	     case "checkinstall": {	$this->checkInstall(); break; }
	 	     case "configuration": { $this->configInstall(); break; }
	 	     case "adminsetup": { $this->adminSetup(); break; }
	 	     case "finish": { $this->finishInstall(); break; }
	 	 }
	 	 $this->oTmpl->navBar($showNavBar);
	 	 $this->oTmpl->statusBar();
	 }
	 
	 /**
	  * destrutor :(
	  */
	 function end() {
	 	 $this->oTmpl->footer();
	 }
	
	/*
	 * Dump de variavies 
	 */
	 function varDump($arg) {
		echo "<pre>";
		var_dump($arg);
		echo "</pre>";
	 }
	 
	 /*
	  * Verifica os requisitos e as recomenda��es para instala��o
	  */
	 function checkInstall() {
	 	/*
	 	 * por padrao poder� continuar o processo de installa��o
	 	 */
	 	$lCouldContinue = true;
	 	$msgLegenda = '';
	 	
	 	/*
	 	 * verifica a versao do PHP para o CACIC
	 	 */
	 	$this->oTmpl->addVar('tmplNavBarCheckInstall', 'CACIC_PHPVERSION', CACIC_PHPVERSION);
	 	if(version_compare(phpversion(),CACIC_PHPVERSION,'>=')) {
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPVERSION_STATUS', "Sim (".phpversion().")");
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPVERSION_CLASS', "SimImg");
	 	}  
	 	else {
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPVERSION_STATUS', "N�o (".phpversion().")");
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPVERSION_CLASS', "NaoImg");
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPVERSION_HELP', "Para executar o CACIC � necess�rio instalar a vers�o do PHP indicada.");
	 	  $lCouldContinue = false;
	 	}
	 	
	 	/*
	 	 * verifica se o biblioteca MYSQL est� instalada; testando se a fun��o mysql_connect existe
	 	 */
		if (extension_loaded('gd') || function_exists('imagegd')) {
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPGD_STATUS', "Sim");
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPGD_CLASS', "SimImg");
	 	}  
	 	else {
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPGD_STATUS', "N�o");
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPGD_CLASS', "NaoImg");
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPGD_HELP', "Para executar o CACIC � necess�rio instalar a biblioteca de manipula��o de imagens com GD.");
	 	  $lCouldContinue = false;
	 	}
	 	
	 	/*
	 	 * verifica suporte a mCrypt; testando se a fun��o mcrypt_generic existe
	 	 */
		if (function_exists('mcrypt_generic')) {
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPMCRYPT_STATUS', "Sim");
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPMCRYPT_CLASS', "SimImg");
	 	}  
	 	else {
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPMCRYPT_STATUS', "N�o");
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPMCRYPT_CLASS', "NaoImg");
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPMCRYPT_HELP', "Para executar o CACIC � necess�rio instalar a biblioteca de manipula��o criptogr�fica com MCrypt.");
	 	  $lCouldContinue = false;
	 	}
	 	
	 	/*
	 	 * verifica se o biblioteca MYSQL est� instalada; testando se a fun��o mysql_connect existe
	 	 */
	 	$this->oTmpl->addVar('tmplNavBarCheckInstall', 'CACIC_MYSQLVERSION', CACIC_DBVERSION);
		if (function_exists('mysql_connect') and (version_compare(mysql_get_client_info(),CACIC_DBVERSION,'>='))) {
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPMYSQL_STATUS', "Sim ".mysql_get_client_info());
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPMYSQL_CLASS', "SimImg");
	 	}  
	 	else {
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPMYSQL_STATUS', "N�o ".mysql_get_client_info());
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPMYSQL_CLASS', "NaoImg");
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPMYSQL_HELP', "Para executar o CACIC � necess�rio instalar a biblioteca para banco de dados MYSQL.");
	 	  $lCouldContinue = false;
	 	}
	 	
	 	/*
	 	 * verifica se � possivel escrever o arquivo de configura��es para o CACIC
	 	 */
		if (is_writable(CACIC_CFGFILE_PATH)) {
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'CFGFILE_STATUS', "Sim");
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'CFGFILE_CLASS', "SimImg");
	 	  $_SESSION['saveCfgFile'] = true;
	 	}  
	 	else {
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'CFGFILE_STATUS', "N�o");
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'CFGFILE_CLASS', "AvisoImg");
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'CFGFILE_HELP', "Voc� poder� continuar a instala��o e o arquivo poder� (opcionalmente) ser mostrado na tela. Assim, voc� poder� copi�-lo e col�-lo no devido diret�rio.");
	 	  $_SESSION['saveCfgFile'] = false;
	 	}
	 	
	 	/*
	 	 * verifica se Register_globals est� ativa
	 	 */
	 	 $phpRGStatus = ((strtoupper(ini_get('register_globals')) == 'ON') or (ini_get('register_globals') == 1)) ? "ON" : "OFF";
	 	 $cacicRG = (strtoupper(CACIC_PHPRG) == 'ON' or CACIC_PHPRG == 1) ? "ON" : "OFF";
	 	  
	 	if ($cacicRG == $phpRGStatus) {
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'CACIC_PHPRG', $cacicRG );
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPRG_STATUS', $phpRGStatus);
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPRG_CLASS', "SimImg");
	 	}
	 	else {
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'CACIC_PHPRG', $cacicRG);
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPRG_STATUS', $phpRGStatus);
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPRG_CLASS', "NaoImg");
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPRG_HELP', "Para que o CACIC funcione corretamente � necess�rio - por enquanto - ativar essa diretiva.");
	 	  $lCouldContinue = false;
	 	}
	 	
	 	/*
	 	 * verifica se Register_long_arrays est� ativa
	 	 */
	 	 $phpRLAStatus = ((strtoupper(ini_get('register_long_arrays')) == 'ON') or (ini_get('register_long_arrays') == 1)) ? "ON" : "OFF";
	 	 $cacicRLA = (strtoupper(CACIC_PHPRLA) == 'ON' or CACIC_PHPRLA == 1) ? "ON" : "OFF";
	 	if(version_compare(phpversion(),'5.0.0','>=') and version_compare(phpversion(),'6.0.0','<')) {
		 	if ($cacicRLA == $phpRLAStatus) {
		 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'CACIC_PHPRLA', $cacicRLA );
		 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPRLA_STATUS', $phpRLAStatus);
		 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPRLA_CLASS', "SimImg");
		 	}
		 	else {
		 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'CACIC_PHPRLA', $cacicRLA);
		 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPRLA_STATUS', $phpRLAStatus);
		 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPRLA_CLASS', "NaoImg");
		 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPRLA_HELP', "Para que o CACIC funcione corretamente � necess�rio - por enquanto - ativar essa diretiva.");
		 	  $lCouldContinue = false;
		 	}
	 	}
	 	else {
		  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPRLA_CLASS', "AvisoImg");
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPRLA_HELP', "Essa diretiva � verificada apenas para vers�o PHP = 5.x.y.");
	 	}
	 	
	 	/*
	 	 * verifica se Memoria Limite de execu��o de programas PHP
	 	 */
	 	$this->oTmpl->addVar('tmplNavBarCheckInstall', 'CACIC_PHPMEM', CACIC_PHPMEM);
		if ((integer)(ini_get('memory_limit'))>=(integer)(CACIC_PHPMEM)) {
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPMEM_STATUS', ini_get('memory_limit'));
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPMEM_CLASS', "SimImg");
	 	}  
	 	else {
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPMEM_STATUS', ini_get('memory_limit'));
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPMEM_CLASS', "AvisoImg");
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstall', 'PHPMEM_HELP', "Essa diretiva ir� afetar o desempenho de execu��o dos programas em PHP.");
	 	}
	 	$msgLegenda .= 'Legenda: <span class="SimImg"> </span> &nbsp;- Verifica��o satisfeita &nbsp;&nbsp;';
	 	$msgLegenda .= '<span class="NaoImg"> </span> &nbsp;- Verifica��o n�o satisfeita &nbsp;&nbsp;';
	 	$msgLegenda .= '<span class="AvisoImg"> </span> &nbsp;- Alerta, mas pode continuar';
	 	
	 	/*
	 	 * caso possa continuar o processo mostra botao proximo
	 	 */
	 	if($lCouldContinue)
	 	  $this->oTmpl->addVar('tmplNavBarCheckInstallContinue', 'continuar', "sim");
	 	else
	 	  $msgLegenda .= '<br><span class="erro">Por favor, corrija pend�ncias para continuar processo de instala��o!</span><br><br>';
	 	  
	 	$this->oTmpl->addVar('tmplStatusBar', 'MSG_STATUS', $msgLegenda);
	 	  
	 }
	 
	 /*
	  * Atribui dados padrao ao formul�rio de configura��es
	  */
	  function configInstall() {
	    global $cacic_updateFromVersion, $cacic_config;
        $_versionList = array();
        foreach($cacic_updateFromVersion as $_versionId => $_versionName) {
            $selected = $cacic_config['install']['updateFromVersion'] == $versionId ? '' : "selected";
            $_arrAux = array( 
                            array( 
                                    'VERSION_SELECTED' => $selected,
                                    'VERSION_ID' => $_versionId,
                                    'VERSION_NAME' => $_versionName
                                )
                            );
            $_versionList = array_merge($_versionList,$_arrAux);
        }
     	// Atribui os dados de configura��o de banco para inser��o dos dados administrativos
        $this->oTmpl->addRows('cacic_updateFromVersion', $_versionList );
    	$this->setInputFields('tmplNavBarConfiguration');
	  } 
	  
	 /*
	  * Atribui dados padrao ao formul�rio de administra��o
	  */
	  function adminSetup() {
     	// Atribui os dados de configura��o de banco para inser��o dos dados administrativos
	  	$this->setInputFields('tmplNavBarAdminSetup');
    	  	
     	//$this->vardump($cacic_config);
	  } 
	  
	 /*
	  * Atribui dados padrao aos campos do formulario
	  */
	  function setInputFields($template) {
     	
    	 // Campos padrao
         $this->oTmpl->addVar($template, 'CACIC_LANG_CHARSET', CACIC_LANG_CHARSET );
         	
	  	if(isset($_POST['step']))
    	  	$this->oTmpl->addVar($template, 'TASK', $_POST['task']);
	  	if(isset($_POST['step']))
    	  	$this->oTmpl->addVar($template, 'STEP', $_POST['step']);
	  	if(isset($_SESSION['saveCfgFile']) and $_SESSION['saveCfgFile'])
	  	    $this->oTmpl->addVar('tmplNavBarCouldSaveCFGFile', 'salvar', 'sim');
    	  	
     	// coloca os dados de configura��o de banco para inser��o dos dados administrativos
	  	if(isset($_SESSION['cacic_config'])) {
    	  	$cacic_config = $_SESSION['cacic_config'];
    	  	$this->oTmpl->addVar($template, 'CACIC_PATH', $cacic_config['path']);
    	  	$this->oTmpl->addVar($template, 'CACIC_URL', $cacic_config['url']);
    	  	$this->oTmpl->addVar($template, 'DB_TYPE', $cacic_config['db_type']);
    	  	$this->oTmpl->addVar($template, 'DB_HOST', $cacic_config['db_host']);
    	  	$this->oTmpl->addVar($template, 'DB_PORT', $cacic_config['db_port']);
    	  	$this->oTmpl->addVar($template, 'DB_NAME', $cacic_config['db_name']);
    	  	$this->oTmpl->addVar($template, 'DB_USER', $cacic_config['db_user']);
    	  	$this->oTmpl->addVar($template, 'DB_PASS', $cacic_config['db_pass']);
    	  	$this->oTmpl->addVar($template, 'DB_ADMIN', $cacic_config['db_admin']);
    	  	$this->oTmpl->addVar($template, 'DB_ADMIN_PASS', $cacic_config['db_admin_pass']);
    	  	$this->oTmpl->addVar($template, 'INSTALL_TYPE', $cacic_config['install']['type']);
    	  	if($cacic_config['install']['type'] == 'createDB')
    	  	  $this->oTmpl->addVar($template, 'INSTALL_NEW', 'checked');
    	  	if($cacic_config['install']['type'] == 'atualizar')
    	  	  $this->oTmpl->addVar($template, 'INSTALL_UPDATE', 'checked');
	  	}
	  	else {
    	  	$this->oTmpl->addVar($template, 'CACIC_PATH', CACIC_PATH);
    	  	$this->oTmpl->addVar($template, 'CACIC_URL', CACIC_URL);
    	  	$this->oTmpl->addVar($template, 'DB_HOST', "localhost");
    	  	$this->oTmpl->addVar($template, 'DB_PORT', "3306");
    	  	$this->oTmpl->addVar($template, 'DB_NAME', "cacic");
    	  	$this->oTmpl->addVar($template, 'DB_USER', "cacic_db_user");
	  	}
	  	
	  	// Dados administrativos
	  	if(isset($_SESSION['cacic_admin'])) {
    	  	$cacic_admin = $_SESSION['cacic_admin'];
    	  	$this->oTmpl->addVar($template, 'LOCAL_SIGLA', $cacic_admin['local_sigla']);
    	  	$this->oTmpl->addVar($template, 'LOCAL_NOME', $cacic_admin['local_nome']);
    	  	$this->oTmpl->addVar($template, 'LOCAL_OBSERVACAO', $cacic_admin['local_observacao']);
    	  	$this->oTmpl->addVar($template, 'ADMIN_LOGIN', $cacic_admin['admin_login']);
    	  	$this->oTmpl->addVar($template, 'ADMIN_SENHA', $cacic_admin['admin_senha']);
    	  	$this->oTmpl->addVar($template, 'ADMIN_NOME', $cacic_admin['admin_nome']);
    	  	$this->oTmpl->addVar($template, 'ADMIN_EMAIL', $cacic_admin['admin_email']);
    	  	$this->oTmpl->addVar($template, 'ADMIN_FORNE', $cacic_admin['admin_fone']);
     	}
    	  	
     	//$this->vardump($cacic_config);
     	//$this->vardump($cacic_admin);
	  } 
	  
	 /*
	  * Verifica finalizacao da instala��o
	  */
	  function finishInstall() {
	  
	    $msg = "";
	    $cacic_config = $_SESSION['cacic_config'];
	    $cacic_admin = $_SESSION['cacic_admin'];
	    
    	$this->oTmpl->addVar('tmplNavBarFinish', 'CACIC_URL', $cacic_config['url']);
     	
	    $cfgFileName = $cacic_config['path'].'/include/config.php';
	    
	    $cfgFileOk = false;
	    $dbConected = false;
	    $buildDBOK = false;
	    
	    if(!isset($_SESSION['configFileSaved']) or !($_SESSION['configFileSaved']))
	        $msg .= "<span class='Erro'>Grava��o do arquivo de configura��es n�o realizada adequadamente!</span><br>";
	    else {
    	    if(!is_readable($cfgFileName) or ! @include_once($cfgFileName))
    	        $msg .= "<span class='Erro'>N�o foi poss�vel ler o arquivo de configura��es:</span><br>".$cfgFileName;
    	    else
    	        $cfgFileOk = true;
	    }

	    if( isset($_SESSION['buildDBOK']) )
	        $buildDBOK = $_SESSION['buildDBOK'];
	    if(!$buildDBOK)
	        	$msg .= "<span class='Erro'>Constru��o do banco de dados para o CACIC n�o realizada adequadamente!</span><br>";
	    
	    if($cfgFileOk) {
         	$oDB = new ADO();
    		if (!$oDB->conecta( $ip_servidor, $usuario_bd, $senha_usuario_bd, $nome_bd ))
    	        $msg .= "<span class='Erro'>N�o � poss�vel conectar ao banco de dados com os dados do arquivo de configura��es!</span><br>";
    	    else
    	        $dbConected = true;
	    }

	    if($dbConected) {
    	    if(!isset($_SESSION['adminSetupSaved']) or !($_SESSION['adminSetupSaved']))
    	        $msg .= "<span class='Erro'>Dados do Local e Usu�rio administrador n�o gravados no banco de dados!</span><br>";
    	    else {
    	  	    $sql_get_local_id = "select id_local from locais where sg_local = '".$cacic_admin['local_sigla']."'";
    	  	    $oDB->selectDB();
    			$oDB->query($sql_get_local_id);
    			if (!($oDB->numRows() > 0))
    				$msg .= '<span class="Erro">[ ERRO! ] - Local n�o foi cadastrado!</span><br>';
    			
    	  	    $sql_check_admin = "select nm_usuario_acesso from usuarios where nm_usuario_acesso = '".$cacic_admin['admin_login']."'";
    			$oDB->query($sql_check_admin);
    			if (!($oDB->numRows() > 0)) 
    				$msg .= '<span class="Erro">[ ERRO! ] - Administrador n�o foi cadastrado!</span><br>';
    	    }
	    }
	    
	    if(empty($msg))
	        $msg = "<span class='OkImg'>Instala��o do CACIC finalizada e veficada!</span><br>";

    	$this->oTmpl->addVar('tmplStatusBar', 'MSG_STATUS', $msg);
	    
	  }
}
?>

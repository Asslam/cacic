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
//defined( 'CACIC' ) or die( 'Acesso restrito (Restricted access)!' );

  session_start();

	if( ! defined( 'CACIC' ) )
	    define( 'CACIC', 1 );
	    
	// define Path para o CACIC
	$cacic_path = str_replace("instalador", '', dirname(__FILE__));
	define('CACIC_PATH', $cacic_path);

	/*
	 * atribui��es para o ambiente
	 */
	if( ! @include("../include/define.php") )
	{
	   die("Install mal definido (Install miss-defined)!");
	}
	
	/*
	 * classe para instanciar a instala��o
	 */
	if( ! @include("classes/install.php") )
	{
	   die("Install mal constru�do (Install miss-built)!");
	}

	if(!@include_once( TRANSLATOR_PATH.'/Translator.php'))
	  die ("<h1>There is a trouble with phpTranslator package. It isn't found.</h1>");
     
	if(!empty($_POST['translate_lang']))
	   $_SESSION['cacic_language'] = $_POST['translate_lang'];
	elseif(!isset($_SESSION['cacic_language']))
	   $_SESSION['cacic_language'] = CACIC_LANGUAGE;
	
	/*
	 * Esta instancia��o do Translator deve ser identica a realizada pela "include/library.php"
	 */
	 $oTranslator = new Translator( $_SESSION['cacic_language'] , CACIC_PATH."/language/", CACIC_LANGUAGE_STANDARD );
     $oTranslator->setLangFilesInSubDirs(true);
     $oTranslator->setURLPath(TRANSLATOR_PATH_URL);
     $oTranslator->initStdLanguages();
   
	/**
	 * Prove a instancia��o da Instala��o pela WEB
	 */
	 $objInstall = new Install();
	 
	 if(isset($_POST['step']))
	   $objInstall->navBar($_POST['step']);
	 else
	   $objInstall->navBar();
	   
	 $objInstall->end();
	 
?>
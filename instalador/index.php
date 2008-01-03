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
	if( ! @include("../include/library.php") )
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
	  
	// Conjunto de idiomas para os quais o CACIC est� traduzido
	$_SESSION['language_set'] = getLanguages();

     
	if(!empty($_POST['translate_lang']))
	   $_SESSION['cacic_language'] = $_POST['translate_lang'];
	elseif(!isset($_SESSION['cacic_language']))
	   $_SESSION['cacic_language'] = CACIC_LANGUAGE;
	/*
	 * Inicia tradu��o para o idioma selecionado
	 */
    $oTranslator->setLangTgt($_SESSION['cacic_language']);
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
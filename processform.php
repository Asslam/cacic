<?php
session_start();
/*
 * verifica se houve login e tamb�m regras para outras verifica��es (ex: permiss�es do usu�rio)!
 */
if(!isset($_SESSION['id_usuario'])) 
  die('Acesso negado!');
else { // Inserir regras para outras verifica��es (ex: permiss�es do usu�rio)!
}

$password = md5('123456');
$challenge = $_SESSION['challenge'];
if(md5($password.$challenge)==$_POST['challenge'])
	{
  	echo 'Senha Correta';
	}
else
	{
  	echo 'Acesso negado!';
	}
?>

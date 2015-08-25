<?php
session_start();
include './Includes/bdd.php';

$login = $_POST['login'];
$password = md5($_POST['password']);

$sql = "SELECT login, password FROM membres WHERE login='".$login."' AND password='".$password."'";
$req = mysql_query($sql);

$resultat = mysql_fetch_assoc($req);

if($login == $resultat['login'] && $password == $resultat['password'])
{
	$_SESSION['login'] = $login;
	$_SESSION['password'] = $password;
	header("Location: ./accueil.php");
}
else
{
	echo ("Erreur de connexion
			<script language='Javascript'>
				document.location.replace('/1STGAM3/index.html');
			</script>");
}


?>
<?php
session_start();
if(!isset($_SESSION['login'], $_SESSION['password']))
{
	header("Location: ./index.html");
}
?>
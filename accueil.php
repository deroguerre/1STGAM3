<?php
include './Includes/session.php';
include './Includes/bdd.php';
include './Classes/ressources.php';
include './Classes/armee.php';
$minerai = new Ressources();
$armee = new Armee();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>1STGAM3</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="Icon" href="img/sun_stroke_16x16.ico" type="image/x-icon" />
</head>

<body>
<header><?php include 'header.php'; ?></header>
<nav>
<?php include 'nav.php'; ?>
</nav>
<aside>
<?php include 'aside.php'; ?>
</aside>
<section>
<fieldset>
<ul id="menu_horizontal">
    <li>
    	<img src="img/piece.png" width="32" height="32" /> Pièces :
		<?php 	$minerai->afficherPiece() ?>
    </li>
</ul>
</fieldset>
<article>
	<div align="center">
    	<p align="left">NEWS :</p>
   	  <p align="center" style="background-color:#B7CA79">01/02/13 - Changement de l'ago des combats et mise en place d'un wiki sur Github.</p>
      <p align="center" style="background-color:#B7CA79">20/01/13 - La base de donnée à était refondée et par conséquent tout est supprimé !</p>
      </p>
    </div>
</article>
</section>
<footer>
</footer>
</body>
</html>
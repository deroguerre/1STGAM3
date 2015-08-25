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
  	<form method="post" action="Methodes/methodeAcheter.php">
	<table width="369" border="0">
	  	<tr>
	    <td width="156">Soldats (5 pièces) :</td>
	    <td width="34"><input type="text" name="qteSoldat" value="0" size="1" /></td>
        <td width="165">
        max : <?php $armee->afficherMaxSoldat() ?></td>
	    </tr>
        <tr>
        <td>Archers (8 pièces) :</td>
        <td><input type="text" name="qteArcher" value="0" size="1" /></td>
        <td>max :
          <?php $armee->afficherMaxArcher() ?></td>
        </tr>
        <tr>
        <td>Cavaliers (15 pièces) :</td>
        <td><input type="text" name="qteCavalier" value="0" size="1" /></td>
        <td>max :
          <?php $armee->afficherMaxCavalier() ?></td>
        </tr>
        <tr>
        <td><input type="submit" name="button" class="button" value="Acheter" /></td>
        </tr>
	</table>
  	</form>
</div>
</article>
</section>
<footer>
</footer>
</body>
</html>
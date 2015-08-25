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
		<p style="background-color:#C4D7ED">Points d'action : <?php $armee->afficherPa() ?></p>
		<?php
            $sql="SELECT login, nb_victoire FROM membres, armees WHERE membres.id = armees.id ORDER BY nb_victoire DESC";
            $req=mysql_query($sql);
            while($rep=mysql_fetch_array($req))
            {
        	echo "<table width='350' border='0'>
          			<tr>
						<td width='100'>";echo $rep['login']."</td>
						<td width='100'>Victoires : ".$rep['nb_victoire'];echo "</td>
						<td width='100'>";
						if($rep['login'] != $_SESSION['login'])
						{
							echo "<a href='attaquerResult.php?whoFight=".$rep['login']."'>Attaquer</a>";
						}
						echo "</td>
          			</tr>
        		</table>";
            }
        ?>
    </div>
</article>
</section>
<footer>
</footer>
</body>
</html>
<?php
include './Includes/bdd.php';

if ((isset($_POST['login']) && !empty($_POST['login'])) && (isset($_POST['password']) && !empty($_POST['password'])) && (isset($_POST['password2']) && !empty($_POST['password2'])))
{
	if ($_POST['password'] != $_POST['password2'])
	{
		$resultat = 'Les deux mots de passe sont différents.';
	}
	else
	{
		// on recherche si ce login est déjà utilisé par un autre membre
		$sql = 'SELECT count(*) FROM membres WHERE login="'.$_POST['login'].'"';
		$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
		$data = mysql_fetch_array($req);

		if ($data[0] == 0)
		{
			//Créer le membre
			$sql = "INSERT INTO membres (login, password) VALUES ('".mysql_real_escape_string($_POST['login'])."','".md5($_POST['password'])."')";
			mysql_query($sql) or die('Erreur SQL !'.$sql.'<br />'.mysql_error());
			
			$sql = "SELECT id FROM membres WHERE login='".$_POST['login']."'";
			$req = mysql_query($sql) or die('Erreur SQL !'.$sql.'<br />'.mysql_error());
			$rep = mysql_fetch_array($req);
			
			//Créer les ressources du membre
			$sql = "INSERT INTO ressources (id, date_pieces, date_pa) VALUES ('".$rep[0]."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."')";
			mysql_query($sql) or die('Erreur SQL !'.$sql.'<br />'.mysql_error());
			
			//Créer l'armée du membre
			$sql = "INSERT INTO armees (id) VALUES ('".$rep[0]."')";
			mysql_query($sql) or die('Erreur SQL !'.$sql.'<br />'.mysql_error());
			
			//Créer l'armée du membre
			$sql = "INSERT INTO batiments (id) VALUES ('".$rep[0]."')";
			mysql_query($sql) or die('Erreur SQL !'.$sql.'<br />'.mysql_error());
			
			header ("Refresh: 3;URL=index.html");
			$resultat = "Inscription réussi.";
		}
		else
		{
			$resultat = 'Ce login est déjà pris !';
			header ("Refresh: 3;URL=index.html");
		}
	}
}
else
{
	$resultat = 'Au moins un des champs est vide.';
	header ("Refresh: 3;URL=index.html");
}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Accueil</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<header><div align="center"><img src="img/logo.png" width="300" height="75" /></div></header>
<nav>
<div align="center">
    <form method="post" action="connexion.php">
        Login:
        <input type="text" name="login" size="15"/>
        Mot de passe:
        <input type="text" name="password" size="15" />
      <input type="submit" name="button" id="button" value="Connexion" />
    </form>
</div>
</nav>
<section><br />
  <article>
    <div align="center">
    <p><strong>Bienvenue</strong></p>
    <p align="left">1STGAM3 est jeux de gestion minimaliste sur navigateur, le but étant de constituer une armée afin d'attaquer les autres joueurs.</p>
    <p align="left">&nbsp;</p>
    <fieldset>
    <?php echo $resultat ?>
    </fieldset>
    </div>
</article>
</section>
<footer>
</footer>
</body>
</html>
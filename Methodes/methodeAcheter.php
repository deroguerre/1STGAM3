<?php
include '../Includes/session.php';
include '../Includes/bdd.php';
include '../Includes/ressources.php';
include '../Includes/armee.php';

$armee = new Armee();
$armee->acheterSoldat($_POST["qteSoldat"], $_POST["qteArcher"], $_POST["qteCavalier"]);

?>

<script language="Javascript">
document.location.replace("/1STGAM3/acheter.php");
</script>
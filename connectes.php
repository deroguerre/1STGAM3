<?php

$req = mysql_query("SELECT COUNT(*) AS nb_entrees FROM connectes WHERE ip='".$_SERVER['REMOTE_ADDR']."'");
$rep = mysql_fetch_array($req);

if ($rep['nb_entrees'] == 0)
{
	mysql_query("INSERT INTO connectes VALUES('".$_SERVER['REMOTE_ADDR']."','".time()."')");
}
else
{
	mysql_query("UPDATE connectes SET timestamp='".time()."' WHERE ip='".$_SERVER['REMOTE_ADDR']."'");
}

$timestamp_5min = time() - (60 * 5);
mysql_query("DELETE FROM connectes WHERE timestamp < ".$timestamp_5min);

$req = mysql_query('SELECT COUNT(*) AS nb_entrees FROM connectes');
$rep = mysql_fetch_array($req);

echo 'Il y a actuellement '.$rep[0].' personnes connectés.';

?>
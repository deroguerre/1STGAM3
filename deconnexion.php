<?php
session_start();
unset($_SESSION);
unset($_COOKIE);
session_destroy();
?>

<script language="Javascript">
document.location.replace("/1STGAM3/index.html");
</script>';
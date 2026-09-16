<?php

session_start();

// limpa as variaveis que estavam alocadas na session
$_SESSION = array();

session_destroy();

header("Location: login.php");
exit();

?>
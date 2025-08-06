<?php
session_start();
$_SESSION = [];
session_destroy();
header("Location: ../cikis-yap.html");
exit();
?>
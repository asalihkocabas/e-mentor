<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
define('SIMULATED_NOW', '2024-10-28 10:15:00');
require_once 'database.php';
?>
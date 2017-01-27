<?php
session_start();

// remise à null de toute les variable session_cache_expire


$_SESSION['login'] = '';
$_SESSION['id'] = '';

session_destroy();
header('location: ./index.php');
?>

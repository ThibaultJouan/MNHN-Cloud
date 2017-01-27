<?php
//connexion a la bdd
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=ARJUPA', 'root', '');
	$bdd->exec("SET CHARACTER SET utf8");
}

catch (Exception $e)
{
	die('Erreur : '.$e->getMessage());
}
?>
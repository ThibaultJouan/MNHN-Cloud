<?php
include_once (__DIR__.'/dao/utilisateur_dao.php');
if($_POST['prenomInscr'] && $_POST['nomInscr'] && $_POST['emailInscr'] && $_POST['mdpInscr']) {
    $prenom = $_POST['prenomInscr'];
	$nom = $_POST['nomInscr'];
	$email = $_POST['emailInscr'];
    $mdp = $_POST['mdpInscr'];
    $success = UtilisateurDao::createUser($prenom,$nom,$email,$mdp);
    if($success)
        header('location:create_validate.html');
    else
        header('location:create_user.php');  
}
else{
    header('location:create_denied.html');  
}
?>
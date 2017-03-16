<?php
include_once (__DIR__.'/../../dao/utilisateur_dao.php');
if($_POST['prenomInscr'] && $_POST['nomInscr'] && $_POST['emailInscr'] && $_POST['mdpInscr']) {
    $prenom = $_POST['prenomInscr'];
	$nom = $_POST['nomInscr'];
	$email = $_POST['emailInscr'];
    $mdp = md5($_POST['mdpInscr'],TRUE);

    $successId = UtilisateurDao::getIdByMail($email);
    $log = Log::getLog();
    if(!$successId){
        $log->info('service : '.$success);
        $success = UtilisateurDao::createUser($prenom,$nom,$email,$mdp);
    }
    if($success)
        header('location:../../view/admin/validate/create_user_validate.html');
    else
        header('location:../../view/admin/validate/create_user_denied.html');  
}
else{
    header('location:../../view/admin/validate/create_user_denied.html');  
}
?>
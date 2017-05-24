<?php
include_once (__DIR__.'/../dao/utilisateur_dao.php');
if(isset($_POST['idUser']) && isset($_POST['pwdUser'])) {
	$id = $_POST['idUser'];
	$pwd= $_POST['pwdUser'];

    if(UtilisateurDao::updatePwdUser($id,$pwd))
        header('location:../view/profile/validate/pwd_change_validation.html');
		else
        header('location:../view/admin/validate/erreur.html');
}
else{
        header('location:../view/admin/validate/erreur.html');
}
?>

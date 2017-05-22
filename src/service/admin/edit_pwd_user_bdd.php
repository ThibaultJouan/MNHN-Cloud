<?php
include_once (__DIR__.'/../../dao/utilisateur_dao.php');
if(isset($_POST['idUser']) && isset($_POST['pwdUser']) ) {
    $id = $_POST['idUser'];
		$pwd= md5($_POST['pwdUser'],TRUE);
    if(UtilisateurDao::updatePwdUser($id,$pwd))
        header('location:../../view/admin/validate/edit_pwd_user_validate.html');
		else
        header('location:../../view/admin/validate/edit_pwd_user_denied.html');
}
else{
        header('location:../../view/admin/validate/edit_pwd_user_denied.html');
}
?>

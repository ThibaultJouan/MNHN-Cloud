<?php
include_once (__DIR__.'/../../dao/utilisateur_dao.php');
if(isset($_POST['idUser']) && isset($_POST['pwdUser']) && isset($_POST['nomUser'])&& isset($_POST['prenomUser'])&& isset($_POST['mailUser'])) {
    $id = $_POST['idUser'];
		$pwd= $_POST['pwdUser'];
		$nom = $_POST['nomUser'];
		$prenom= $_POST['prenomUser'];
		$mail= $_POST['mailUser'];
    if(UtilisateurDao::updateUser($id,$nom,$prenom,$mail,$pwd))
        header('location:../../view/admin/validate/edit_user_validate.html');
		else
        header('location:../../view/admin/validate/edit_user_denied.html');
}
else{
        header('location:../../view/admin/validate/edit_user_denied.html');
}
?>

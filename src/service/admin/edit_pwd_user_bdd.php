<?php
include_once (__DIR__.'/../../dao/utilisateur_dao.php');
if(isset($_POST['idUser']) && isset($_POST['pwdUser']) ) {
    $id = $_POST['idUser'];
		$pwd= $_POST['pwdUser'];
		echo $id;
		echo $pwd;
    UtilisateurDao::updatePwdUser($id,$pwd);
}
else{
}
?>

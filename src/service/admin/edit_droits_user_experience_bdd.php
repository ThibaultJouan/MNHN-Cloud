<?php
include_once (__DIR__.'/../../dao/refexperience_utilisateur_dao.php');
include_once (__DIR__.'/../../dao/refexperience_dao.php');
include_once (__DIR__.'/../../dao/utilisateur_dao.php');
if($_POST['idUser']) {
	$idUser = $_POST['idUser'];
	RefExperience2UtilisateurDao::deleteByIdUser($idUser);
    foreach(RefExperienceDao::getIdByActif() as $row){
        $idExp = $row['id_refexperience'];
        if($_POST[$idExp]=="yes"){
					RefExperience2UtilisateurDao::create($idExp,$idUser);
        }
    }
    header('location:../../view/admin/update/edit_droit_user_project.php?idUser='.$idUser);
}
else{
    header('location:../../view/admin/');
}
?>

<?php
include_once (__DIR__.'/../../dao/projet_utilisateur_dao.php');
include_once (__DIR__.'/../../dao/projet_dao.php');
if($_POST['idUser']) {
    $idUser = $_POST['idUser'];
    Projet2UtilisateurDao::resetChefProjetByIdUser($idUser);
    foreach(ProjetDao::getIdByActif() as $row){
        $idProject = $row['id_projet'];
        if($_POST[$idProject]=="yes"){
           Projet2UtilisateurDao::updateChefProjet($idProject,$idUser);
        }
    }
    header('location:../../view/admin/validate/edit_user_validate.html');
}
else{
    header('location:../../view/admin/validate/edit_user_denied.html');
}
?>

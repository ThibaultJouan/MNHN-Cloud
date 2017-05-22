<?php
include_once (__DIR__.'/../../dao/projet_utilisateur_dao.php');
include_once (__DIR__.'/../../dao/utilisateur_dao.php');
if($_POST['idProject']) {
    $idProject = $_POST['idProject'];
    Projet2UtilisateurDao::deleteByIdProject($idProject);
    foreach(UtilisateurDao::getIdByActif() as $row){
        $idUser = $row['id_utilisateur'];
        if($_POST[$idUser]=="yes"){
            Projet2UtilisateurDao::create($idProject,$idUser);
        }
    }
    header('location:../../view/admin/validate/edit_project_validate.html');
}
else{
    header('location:../../view/admin/validate/edit_project_denied.html');
}
?>

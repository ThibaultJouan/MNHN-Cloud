<?php
include_once (__DIR__.'/../../dao/projet_refexperience_dao.php');
include_once (__DIR__.'/../../dao/refexperience_dao.php');
if($_POST['idProject']) {
    $idProject = $_POST['idProject'];
    Projet2RefExperienceDao::deleteByIdProject($idProject);
    foreach(RefExperienceDao::getIdByActif() as $row){
        $idExperience = $row['id_refexperience'];
        if($_POST[$idExperience]=="yes"){
            Projet2RefExperienceDao::create($idProject,$idExperience);
        }
    }
    header('location:../../view/admin/validate/edit_project_validate.html');
}
else{
    header('location:../../view/admin/validate/edit_project_denied.html');
}
?>

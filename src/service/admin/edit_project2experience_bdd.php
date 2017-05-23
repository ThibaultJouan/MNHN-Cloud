<?php
include_once (__DIR__.'/../../dao/projet_refexperience_dao.php');
include_once (__DIR__.'/../../dao/refexperience_dao.php');
include_once (__DIR__.'/../../dao/projet_dao.php');
include_once (__DIR__.'/../fileTools.php');
include_once (__DIR__.'/../configPath.php');
if($_POST['idProject']) {
    $idProject = $_POST['idProject'];
		$row = ProjetDao::getLibelleById($idProject);
    $libelleProject = $row["libelle_projet"];
    Projet2RefExperienceDao::deleteByIdProject($idProject);
    foreach(RefExperienceDao::getIdByActif() as $row){
        $idExperience = $row['id_refexperience'];
        if($_POST[$idExperience]=="yes"){
						$row = RefExperienceDao::getLibelleActifById($idExperience);
						$libelleExp = $row["libelle_refexperience"];
						$path = PATH_PROJET;
						$path = $path.$libelleProject."/".$libelleExp."/";
						FileTools::makeDirectory($path);
						FileTools::makeDirectory($path."Video");
						FileTools::makeDirectory($path."Force");
						FileTools::makeDirectory($path."Pression");
            Projet2RefExperienceDao::create($idProject,$idExperience);
        }
    }
    header('location:../../view/admin/validate/edit_project_validate.html');
}
else{
    header('location:../../view/admin/validate/edit_project_denied.html');
}
?>

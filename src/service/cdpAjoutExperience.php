<?php
include_once (__DIR__.'/../log/log.php');
include_once (__DIR__.'/../dao/projet_refexperience_dao.php');
include_once (__DIR__.'/../dao/refexperience_dao.php');
include_once (__DIR__.'/../dao/projet_dao.php');
include_once (__DIR__.'/fileTools.php');
include_once (__DIR__.'/configPath.php');

$log = Log::getLog();

if($_POST['libelleExp']){
	$libelleExp = $_POST['libelleExp'];
	$commentaireExp = "";
	if($_POST['commentaireExp']){
		$commentaireExp = $_POST['commentaireExp'];
	}
	RefExperienceDao::createRefExperience($libelleExp, $commentaireExp);
}


$log->info("libelleExp".$libelleExp);
$log->info("commentaireExp".$commentaireExp);
$log->info("idProjet".$_POST['idProject']);


if($_POST['idProject']) {
    $idProject = $_POST['idProject'];
		$row = ProjetDao::getLibelleById($idProject);
    $libelleProject = $row["libelle_projet"];
    foreach(RefExperienceDao::selectAll() as $row){
        if($libelleExp == $row['libelle_refexperience']){
						$idExperience = $row['id_refexperience'];
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
    header('location:../view/admin/validate/edit_project_validate.html');
}
else{
    header('location:../view/admin/validate/edit_project_denied.html');
}
?>

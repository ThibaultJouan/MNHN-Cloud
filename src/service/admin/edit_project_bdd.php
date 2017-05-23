<?php
include_once (__DIR__.'/../../dao/projet_dao.php');
include_once (__DIR__.'/../../service/configPath.php');
include_once (__DIR__.'/../../service/fileTools.php');
if(isset($_POST['idProject']) && isset($_POST['libelleProject']) && isset($_POST['commentProject'])) {
	$id = $_POST['idProject'];
	$row = ProjetDao::getLibelleById($id);
	$ancienNom = $row['libelle_projet'];
	$libelle = $_POST['libelleProject'];
	$ancienPath = PATH_PROJET.$ancienNom;
	$nouveauPath = PATH_PROJET.$libelle;
	$comment = $_POST['commentProject'];
    if($_POST['actifProject'] == "yes")
        $actif = 1;
    else
        $actif = 0;
    if(ProjetDao::updateProject($id,$libelle,$comment,$actif)){
				FileTools::moveFile($ancienPath, $nouveauPath);
        header('location:../../view/admin/validate/edit_project_validate.html');
		}
    else
        header('location:../../view/admin/validate/edit_project_denied.html');
}
else{
    header('location:../../view/admin/validate/edit_project_denied.html');
}
?>

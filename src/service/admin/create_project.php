<?php
include_once (__DIR__.'/../../dao/projet_dao.php');
include_once (__DIR__.'/../../dao/refpath_dao.php');
include_once (__DIR__.'/../fileTools.php');
include_once (__DIR__.'/../configPath.php');
if($_POST['libelleProject']) {
    $libelle = $_POST['libelleProject'];
		$commentaire = "";
    if($_POST['commentProject'])
        $commentaire = $_POST['commentProject'];
    $success = ProjetDao::createProject($libelle,$commentaire);
		if($success){
				$src = RefPathDao::getSrcPath();
				$path = PATH_PROJET;
				$path = $path."".$libelle;
				FileTools::makeDirectory($path);
				header('location:../../view/admin/validate/create_project_validate.html');
		} else
        header('location:../../view/admin/validate/create_project_denied.html');
}
else{
    header('location:../../view/admin/validate/create_project_denied.html');
}
?>

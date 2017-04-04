<?php
include_once (__DIR__.'/../../dao/projet_dao.php');
include_once (__DIR__.'/../../dao/refpath_dao.php');
include_once (__DIR__.'/../fileTools.php');
if($_POST['libelleProject']) {
    $libelle = $_POST['libelleProject'];
		$commentaire = "";
    if($_POST['commentProject'])
        $commentaire = $_POST['commentProject'];
    $success = ProjetDao::createProject($libelle,$commentaire);
		if($success){
				$src = RefPathDao::getSrcPath();
				$path = $src['path_refpath'];
				$path = $path."".$libelle;
				FileTools::makeDirectory($path);
				$pathA = $path."/A";
				FileTools::makeDirectory($pathA);
				$pathB = $path."/B";
				FileTools::makeDirectory($pathB);
				$pathC = $path."/C";
				FileTools::makeDirectory($pathC);
				header('location:../../view/admin/validate/create_project_validate.html');
		} else
        header('location:../../view/admin/validate/create_project_denied.html');
}
else{
    header('location:../../view/admin/validate/create_project_denied.html');
}
?>

<?php
include_once (__DIR__.'/../../dao/projet_dao.php');
if($_POST['libelleProject']) {
    $libelle = $_POST['libelleProject'];
	$commentaire = "";
    if($_POST['commentProject'])
        $commentaire = $_POST['commentProject'];
    $success = ProjetDao::createProject($libelle,$commentaire);
    if($success)
        header('location:../../view/admin/validate/create_project_validate.html');
    else
        header('location:../../view/admin/validate/create_project_denied.html');  
}
else{
    header('location:../../view/admin/validate/create_project_denied.html');  
}
?>
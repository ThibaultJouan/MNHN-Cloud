<?php
include_once (__DIR__.'/../../dao/projet_dao.php');
if(isset($_POST['idProject']) && isset($_POST['libelleProject']) && isset($_POST['commentProject'])) {
    $id = $_POST['idProject'];
	$libelle = $_POST['libelleProject'];
	$comment = $_POST['commentProject'];
    if($_POST['actifProject'] == "yes")
        $actif = 1;
    else
        $actif = 0;
    if(ProjetDAO::updateProject($id,$libelle,$comment,$actif))
        header('location:../../view/admin/validate/edit_project_validate.html');
    else
        header('location:../../view/admin/validate/edit_project_denied.html');  
}
else{
    header('location:../../view/admin/validate/edit_project_denied.html');  
}
?>
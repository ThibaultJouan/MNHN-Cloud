<?php
include_once (__DIR__.'/../../dao/reftypedonnee_dao.php');
if($_POST['libelleDatatype']) {
    $libelle = $_POST['libelleDatatype'];
	$commentaire = "";
    if($_POST['commentDatatype'])
        $commentaire = $_POST['commentDatatype'];
    $success = RefTypeDonneeDao::createRefTypeDonnee($libelle,$commentaire);
    if($success)
        header('location:../../view/admin/validate/create_reftypedonnee_validate.html');
    else
        header('location:../../view/admin/validate/create_reftypedonnee_denied.html');  
}
else{
    header('location:../../view/admin/validate/create_reftypedonnee_denied.html');  
}
?>
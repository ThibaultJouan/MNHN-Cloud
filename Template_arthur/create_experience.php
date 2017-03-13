<?php
include_once (__DIR__.'/dao/refexperience_dao.php');
if($_POST['libelleExperience']) {
    $libelle = $_POST['libelleExperience'];
	$commentaire = "";
    if($_POST['commentExperience'])
        $commentaire = $_POST['commentExperience'];
    $success = RefExperienceDao::createRefExperience($libelle,$commentaire);
    if($success)
        header('location:create_experience_validate.html');
    else
        header('location:create_experience_denied.html');  
}
else{
    header('location:create_experience_denied.html');  
}
?>
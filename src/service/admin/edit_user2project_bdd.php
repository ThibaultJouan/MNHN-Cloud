
<?php
include_once (__DIR__.'/../../dao/projet_utilisateur_dao.php');
include_once (__DIR__.'/../../dao/projet_dao.php');
if($_POST['idUser']) {
    $idUser = $_POST['idUser'];
    foreach(ProjetDao::getIdByActif() as $row){
        $idProject = $row['id_projet'];
        if($_POST[$idProject]=="yes"){
					if(Projet2UtilisateurDao::contains($idProject,$idUser) == 0){
						Projet2UtilisateurDao::create($idProject,$idUser);
					}
        }
    }
    header('location:../../view/admin/update/edit_droit_user_project.php?idUser='.$idUser);
}
else{
    header('location:../../view/admin/validate/edit_user_denied.html');
}
?>

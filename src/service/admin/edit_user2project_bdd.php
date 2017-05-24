
<?php
include_once (__DIR__.'/../../dao/projet_utilisateur_dao.php');
include_once (__DIR__.'/../../dao/projet_dao.php');
if($_POST['idUser']) {
    $idUser = $_POST['idUser'];
    Projet2UtilisateurDao::deleteByIdUser($idUser);
    foreach(ProjetDao::getIdByActif() as $row){
        $idProjet = $row['id_projet'];
        if($_POST[$idProjet]=="yes"){
           Projet2UtilisateurDao::create($idProjet,$idUser);
        }
    }
    header('location:../../view/admin/update/edit_droit_user_project.php?idUser='.$idUser);
}
else{
    header('location:../../view/admin/validate/edit_user_denied.html');
}
?>

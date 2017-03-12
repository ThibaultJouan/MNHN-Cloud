<?php
include_once (__DIR__.'/dao/utilisateur_dao.php');
if($_POST['rowid']) {
    $id = $_POST['rowid'];
    UtilisateurDao::switchActif($id);          
}
?>
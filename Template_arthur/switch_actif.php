<?php
include_once ('utilisateur_dao.php');
if($_POST['rowid']) {
    $id = $_POST['rowid'];
    UtilisateurDao::switchActif($id);          
}
?>
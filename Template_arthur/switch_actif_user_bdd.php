<?php
include_once (__DIR__.'/dao/utilisateur_dao.php');
if($_POST['rowid']) {
    $log = Log::getLog();
    $log->info("yooooo");
    $id = $_POST['rowid'];
    UtilisateurDao::switchActif($id);          
}
else{
        $log = Log::getLog();
    $log->info("NNNOOOOOOO    yooooo");
}
?>
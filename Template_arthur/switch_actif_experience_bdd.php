<?php
include_once (__DIR__.'/dao/refexperience_dao.php');
if($_POST['rowid']) {
    $id = $_POST['rowid'];
    RefExperienceDao::switchActif($id);          
}
?>
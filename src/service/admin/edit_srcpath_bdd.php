<?php
include_once (__DIR__.'/../../dao/refpath_dao.php');
if(isset($_POST['srcPath'])) {
    $path = $_POST['srcPath'];
    RefPathDAO::updateSrcPath($path);
    header('location:../../view/admin/index.php');
}
else{
    header('location:../../view/admin/index.php');
}
?>

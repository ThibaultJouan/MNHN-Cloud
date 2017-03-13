<?php
include_once 'firstTry.php';

session_start();

$_SESSION['Admin'] = true;

fileTools::createFile($_SESSION, "test.txt");
fileTools::moveFile($_SESSION, "test.txt", "Test.txt");
//fileTools::deleteFile($_SESSION, "Test.txt");
fileTools::makeDirectory($_SESSION, "testRepo");


echo 'lol plz\n';

?>

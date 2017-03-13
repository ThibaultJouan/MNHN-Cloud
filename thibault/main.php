<?php
include_once 'firstTry.php';

session_start();

$_SESSION['Admin'] = true;

createFile($_SESSION, "test.txt");
moveFile($_SESSION, "test.txt", "Test.txt");
//deleteFile($_SESSION, "Test.txt");

echo 'lol plz\n';

?>

<?php
include_once(__DIR__.'/../src/log/log.php');
$directory = '/var/www/html/MNHN-Cloud/thibault/upload/';
$file = $directory. 'buffer2.png';
$log = Log::getLog();

if(!$file)
{
	$log->error("Fichier non trouve : ". $file);
	die('Fichier non trouve');
}
else
{
		header("Cache-Control: public");
    header("Content-Description: image Transfer");
    header("Content-Disposition: attachment; filename=$file");
    header("Content-Type: image/png");
		header("Content-Transfer-Encoding: binary");
    readfile($file);
		$log->info("Fichier envoye :". $file);
}
?>

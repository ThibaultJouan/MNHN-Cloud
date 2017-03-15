<?php
$directory = '/var/www/html/MNHN-Cloud/thibault/upload/';
$file = $directory. 'buffer2.png';

if(!$file)
{
	die('file not founs');
}
else
{
		header("Cache-Control: public");
    header("Content-Description: image Transfer");
    header("Content-Disposition: attachment; filename=$file");
    header("Content-Type: image/png");
		header("Content-Transfer-Encoding: binary");
    readfile($file);
}
?>

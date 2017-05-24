<?php
include_once(__DIR__.'/../log/log.php');
include_once(__DIR__.'/../dao/projet_dao.php');
include_once(__DIR__.'/../dao/refexperience_dao.php');
include_once(__DIR__.'/../service/configPath.php');
$fileName = $_GET['fileName'];
$idProjet = $_GET['projet'];
$idExp = $_GET['exp'];
$section = $_GET['section'];
$log = Log::getLog();
$path = PATH_PROJET;


$row = ProjetDao::getLibelleById($idProjet);
$pathProjet = $path.$row['libelle_projet'];
$row = RefExperienceDao::getLibelleActifById($idExp);
$pathExperience = $pathProjet.'/'.$row['libelle_refexperience'];
$directory = $pathExperience.'/'.$section;

$file = $directory.'/'.$fileName;

if(is_file($file)) {

	// required for IE
	if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off');	}

	// get the file mime type using the file extension
	switch(strtolower(substr(strrchr($fileName, '.'), 1))) {
		case 'pdf': $mime = 'application/pdf'; break;
		case 'zip': $mime = 'application/zip'; break;
		case 'jpeg':
		case 'jpg': $mime = 'image/jpg'; break;
		case 'png': $mime = 'image/png'; break;
		default: $mime = 'application/force-download';
	}
	header('Pragma: public'); 	// required
	header('Expires: 0');		// no cache
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($file)).' GMT');
	header('Cache-Control: private',false);
	header('Content-Type: '.$mime);
	header('Content-Disposition: attachment; filename="'.basename($file).'"');
	header('Content-Transfer-Encoding: binary');
	header('Content-Length: '.filesize($file));	// provide file size
	header('Connection: close');
	readfile($file);		// push it out
	exit();

}

?>

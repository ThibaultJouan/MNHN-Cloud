<?php

include_once(__DIR__.'/../src/log/log.php');

$path ='/var/www/html/MNHN-Cloud/thibault/upload/';
$filePath = $path . basename($_FILES['fichier']['name']);
$log = Log::getLog();


if(move_uploaded_file($_FILES['fichier']['tmp_name'], $filePath)) {
    echo "Le fichier ".  basename( $_FILES['fichier']['name']).
    " a ete envoye au serveur ";
		$log->info("Le fichier ".  basename( $_FILES['fichier']['name']).
    " a ete envoye au serveur");
} else{
    echo "Une erreur s'est produite, veuillez reessayer";
		$log->error("Erreur lors du tranfert de fichier " .$FILES['fichier']['name']);
}
?>

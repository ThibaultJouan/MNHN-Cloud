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


/*
if(isset($_FILES["fichier"]["error"])){
		if($_FILES["fichier"]["error"] > 0){
		} else{
				$allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
				$filename = $_FILES["fichier"]["name"];
				$filetype = $_FILES["fichier"]["type"];
				$filesize = $_FILES["fichier"]["size"];

				//Verifie l'extension du fichier
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				//if(!array_key_exists($ext, $allowed)) die("Merci de selectioner un fichier au format autorise");

				// Verifie la taille du fichier - 5Mo maximum
				/*$maxsize = 5 * 1024 * 1024;
				if($filesize > $maxsize) die("Le fichier depasse la taille maximum autorise");*/
				//Verifier le type mime du fichier ? decommenter $allowed pour ca
//				if(in_array($filetype, /*$allowed*/)){
					//Verifier si le fichier existe
/*						if(file_exists( $path .$_FILES["fichier"]["name"])){
								$log->info( $path .$_FILES["fichier"]["name"] . " existe deja.");
								echo "coucou";
						} else{
							move_uploaded_file($_FILES["fichier"]["tmp_name"],
										 $path .$_FILES["fichier"]["name"]);
								$log->info("Fichier cree avec succes");
						}
				} else{
						$log->error("Une erreur est survenue pendant l'upload du fichier");
						echo "LOL";
				}
		}
} else{
		$log->error("Erreur : Parametre invalide");
		echo "POUET POUET";
}*/


?>

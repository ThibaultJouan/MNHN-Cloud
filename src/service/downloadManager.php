<?php
include_once(__DIR__.'/../log/log.php');
include_once(__DIR__."/configPath.php");
include_once(__DIR__."/../dao/projet_dao.php");
include_once(__DIR__."/../dao/donnee_dao.php");
include_once(__DIR__."/../dao/refexperience_dao.php");

$log = Log::getLog();

session_start();

$idUser = $_SESSION['id_utilisateur'];
$idProjet = $_POST['id_projet'];
$idExp = $_POST['id_exp'];
$section = $_POST['section'];
$commentaire = $_POST['commentaire'];

$path = PATH_PROJET;
$row = ProjetDao::getLibelleById($idProjet);
$pathProjet = $path.$row['libelle_projet'];
$row = RefExperienceDao::getLibelleActifById($idExp);
$pathExperience = $pathProjet.'/'.$row['libelle_refexperience'];
$directory = $pathExperience.'/'.$section.'/';

if ($_FILES['nom_du_fichier']['error']) {
          switch ($_FILES['nom_du_fichier']['error']){
                   case 1: // UPLOAD_ERR_INI_SIZE
                   echo"Le fichier dépasse la limite autorisée par le serveur (fichier php.ini) !";
									 $log->error("Le fichier dépasse la limite autorisée par le serveur (fichier php.ini) !");
                   break;
                   case 2: // UPLOAD_ERR_FORM_SIZE
                   echo "Le fichier dépasse la limite autorisée dans le formulaire HTML !";
									 $log->error("Le fichier dépasse la limite autorisée dans le formulaire HTML !");
                   break;
                   case 3: // UPLOAD_ERR_PARTIAL
                   echo "L'envoi du fichier a été interrompu pendant le transfert !";
									 $log->error("L'envoi du fichier a été interrompu pendant le transfert !");
                   break;
                   case 4: // UPLOAD_ERR_NO_FILE
                   echo "Le fichier que vous avez envoyé a une taille nulle !";
									 $log->error("Le fichier que vous avez envoyé a une taille nulle !");
                   break;
          }
}
else {
 // $_FILES['nom_du_fichier']['error'] vaut 0 soit UPLOAD_ERR_OK
 // ce qui signifie qu'il n'y a eu aucune erreur

	if(isset($_FILES['nom_du_fichier'])){
		echo 'succes<br/>';

		DonneeDao::createDonnee($_FILES['nom_du_fichier']['name'], $commentaire, 1, date('Y-m-d H::m::s'), $section, $idUser, $idExp);
		move_uploaded_file($_FILES['nom_du_fichier']['tmp_name'], $directory.$_FILES['nom_du_fichier']['name']);
		$log->info("le fichier ".$_FILES['nom_du_fichier']['name']." a ete upload sur le serveur");
	}
}
?>

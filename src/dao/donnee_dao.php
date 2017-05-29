<?php
include_once(__DIR__.'/../service/database.php');
include_once(__DIR__.'/../log/log.php');

class DonneeDao
{
	private static $data = null;

	public function __construct() {
		die('Init function is not allowed');
	}

	public static function createDonnee($nomFichier, $commentaire, $actif, $dateCreation, $type, $idUser, $idExp)
	{
		$log = Log::getLog();
		$pdo = Database::connect();
		$sql = "INSERT INTO donnee (nomfichier_donnee, commentaire_donnee, actif_donnee, datecreation_donnee, type_donnee, id_utilisateur, id_refexperience) VALUES ( ? , ? , ? , ? , ? , ? , ? )";
		$req = $pdo->prepare($sql);
		if($req->execute(array($nomFichier, $commentaire, $actif, $dateCreation, $type, $idUser, $idExp)))
			$log->info("Création de la donnee ".$nomFichier);
		else{
			$log->error("Echec de la création de la donnee ".$nomFichier);
			Database::disconnect();
			return 0;
		}
		Database::disconnect();
		return 1;
	}

	public static function selectAll()
	{
		$pdo = Database::connect();
		$sql = 'SELECT nomfichier_donnee, commentaire_donnee, actif_donnee, datecreation_donnee, type_donnee, id_utilisateur, id_refexperience FROM donnee ORDER BY id_donnee DESC';
		self::$data = $pdo->query($sql);
		Database::disconnect();
		return self::$data;
	}
}

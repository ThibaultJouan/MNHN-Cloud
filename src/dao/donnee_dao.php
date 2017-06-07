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
	
	public static function cinqDerniereMAJ()
	{
		$pdo = Database::connect();
		$sql = 'SELECT projet.libelle_projet, refexperience.libelle_refexperience, donnee.nomfichier_donnee,utilisateur.prenom_utilisateur, utilisateur.nom_utilisateur, donnee.datecreation_donnee FROM donnee left JOIN refexperience on donnee.id_refexperience = refexperience.id_refexperience left JOIN utilisateur on donnee.id_utilisateur = utilisateur.id_utilisateur LEFT JOIN projet2refexperience on refexperience.id_refexperience = projet2refexperience.id_refexperience LEFT JOIN projet on projet2refexperience.id_projet = projet.id_projet order by datecreation_donnee LIMIT 5';
		self::$data = $pdo->query($sql);
		Database::disconnect();
		return self::$data;
	}
	
	public static function cinqDerniereMAJByIdUtilisateur($IdUtilisateur)
	{
		$pdo = Database::connect();
		$sql = 'SELECT projet.libelle_projet, refexperience.libelle_refexperience, donnee.nomfichier_donnee,utilisateur.prenom_utilisateur, utilisateur.nom_utilisateur, donnee.datecreation_donnee FROM donnee left JOIN refexperience on donnee.id_refexperience = refexperience.id_refexperience left JOIN utilisateur on donnee.id_utilisateur = utilisateur.id_utilisateur LEFT JOIN projet2refexperience on refexperience.id_refexperience = projet2refexperience.id_refexperience LEFT JOIN projet on projet2refexperience.id_projet = projet.id_projet where donnee.id_utilisateur = 2 order by datecreation_donnee LIMIT 5';
		$sth = $pdo->prepare($sql);
        $sth->execute(array($IdUtilisateur));
        self::$data = $sth->fetchAll();
        Database::disconnect();
        return self::$data;	
	}
}
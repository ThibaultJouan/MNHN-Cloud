<?php
include_once(__DIR__.'/../service/database.php');
include_once(__DIR__.'/../log/log.php');
class Projet2UtilisateurDao
{
    private static $data  = null;

    public function __construct() {
        die('Init function is not allowed');
    }

    public static function create($idProject, $idUser)
    {
        $log = Log::getLog();
        $pdo = Database::connect();
        $sql = "INSERT INTO projet2utilisateur (id_projet, id_utilisateur)
            VALUES ( ? , ?)";
        $sth = $pdo->prepare($sql);
        if($sth->execute(array($idProject,$idUser)))
            $log->info("Relation projet: ".$idProject." utilisateur: ".$idUser." créé!");
        Database::disconnect();
        return 1;
    }

    public static function deleteByIdProject($idProject)
    {
        $log = Log::getLog();
        $pdo = Database::connect();
        $sql = "DELETE FROM projet2utilisateur WHERE id_projet = ? ";
        $sth = $pdo->prepare($sql);
        if($sth->execute(array($idProject)))
            $log->info("Clean des relations projet: ".$idProject." vers les utilisateurs !");
        Database::disconnect();
        return 1;
    }

    public static function deleteByIdUser($idUser)
    {
        $log = Log::getLog();
        $pdo = Database::connect();
        $sql = "DELETE FROM projet2utilisateur WHERE id_utilisateur = ? ";
        $sth = $pdo->prepare($sql);
        if($sth->execute(array($idUser)))
            $log->info("Clean des relations utilisateur: ".$idUser." vers les projets !");
        Database::disconnect();
        return 1;
		}

    public static function selectAllByIdUser($idUser)
    {
        $pdo = Database::connect();
        $sql = "SELECT DISTINCT id_utilisateur, id_projet, chef_projet FROM projet2utilisateur WHERE id_utilisateur = ".$idUser;
				self::$data=$pdo->query($sql);
        Database::disconnect();
        return self::$data;
    }

		public static function resetChefProjetByIdUser($idUser){
			  $log = Log::getLog();
        $pdo = Database::connect();
        $sql = "UPDATE projet2utilisateur SET chef_projet = 0 WHERE id_utilisateur = ?";
				$sth = $pdo->prepare($sql);
				if($sth->execute([$idUser]))
					$log ->info("Clean des droits projet pour l'utilisateur: ".$idUser);
				else
					$log ->error("Echec du clean des droits projet pour l'utilisateur: ".$idUser);
				Database::disconnect();
				return 1;
		}

		public static function updateChefProjet($idProject,$idUser){
			  $log = Log::getLog();
        $pdo = Database::connect();
        $sql = "UPDATE projet2utilisateur SET chef_projet = 1 WHERE id_utilisateur = ? AND id_projet = ?";
				$sth = $pdo->prepare($sql);
				if($sth->execute([$idUser,$idProject]))
					$log ->info("Affectation des droits projet:".$idProject."   pour l'utilisateur: ".$idUser);
				else
					$log ->error("Echec affectation des droits projet:".$idProject."   pour l'utilisateur: ".$idUser);
				Database::disconnect();
				return 1;
		}

		public static function contains($idProject,$idUser){
			$pdo = Database::connect();
			$sql = "SELECT COUNT(*) AS count FROM projet2utilisateur WHERE id_projet = ".$idProject." AND id_utilisateur = ".$idUser." LIMIT 1";
			self::$data = $pdo->query($sql);
			Database::disconnect();
			if(self::$data->fetchColumn() > 0 )
				return 1;
			return 0;
		}

    public static function isChefProjet($idProject, $idUser)
    {
        $pdo = Database::connect();
        $sql = "SELECT chef_projet FROM projet2utilisateur WHERE id_projet = ? AND id_utilisateur = ? LIMIT 1 ";
        $sth = $pdo->prepare($sql);
        $sth->execute(array($idProject,$idUser));
        self::$data = $sth->fetch();
        Database::disconnect();
        return self::$data['chef_projet'];
    }

}
?>

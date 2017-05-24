<?php
include_once(__DIR__.'/../service/database.php');
include_once(__DIR__.'/../log/log.php');
class RefExperience2UtilisateurDao
{
    private static $data  = null;

    public function __construct() {
        die('Init function is not allowed');
    }

    public static function create($idExperience, $idUser)
    {
        $log = Log::getLog();
        $pdo = Database::connect();
        $sql = "INSERT INTO experience2utilisateur (id_refexperience, id_utilisateur)
            VALUES ( ? , ?)";
        $sth = $pdo->prepare($sql);
        if($sth->execute(array($idExperience,$idUser)))
            $log->info("Relation experience: ".$idExperience." utilisateur: ".$idUser." créé!");
        Database::disconnect();
        return 1;
    }

    public static function deleteByIdExperience($idExperience)
    {
        $log = Log::getLog();
        $pdo = Database::connect();
        $sql = "DELETE FROM experience2utilisateur WHERE id_refexperience = ? ";
        $sth = $pdo->prepare($sql);
        if($sth->execute(array($idExperience)))
            $log->info("Clean des relations experience: ".$idExperience." vers les utilisateurs !");
        Database::disconnect();
        return 1;
    }

    public static function deleteByIdUser($idUser)
    {
        $log = Log::getLog();
        $pdo = Database::connect();
        $sql = "DELETE FROM experience2utilisateur WHERE id_utilisateur = ? ";
        $sth = $pdo->prepare($sql);
        if($sth->execute(array($idUser)))
            $log->info("Clean des relations utilisateur: ".$idUser." vers les experiences !");
        Database::disconnect();
        return 1;
    }

		public static function contains($idUser,$idExp){
        $pdo = Database::connect();
				$sql = "SELECT * AS count FROM `experience2utilisateur` WHERE id_refexperience = ".$idExp." AND id_utilisateur = ".$idUser." LIMIT 1";
				self::$data = $pdo->query($sql);
        Database::disconnect();
				return self::$data;
		}
}
?>

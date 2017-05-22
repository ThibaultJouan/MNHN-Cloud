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
        $log->info('idProject : '.$idProject);
        $log->info('idUser : '.$idUser);
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

    public static function isJoin($idProject, $idUser)
    {
        $pdo = Database::connect();
        $sql = "SELECT id_projet FROM projet2utilisateur WHERE id_projet = ? AND id_utilisateur = ? LIMIT 1 ";
        $sth = $pdo->prepare($sql);
        $sth->execute(array($idProject,$idUser));
        self::$data = $sth->fetch();
        Database::disconnect();
        if(self::$data == null)
            return 0;
        return 1;
    }

}
?>

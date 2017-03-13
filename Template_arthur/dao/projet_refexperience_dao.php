<?php
include_once(__DIR__.'/../database.php');
include_once(__DIR__.'/../log/log.php');
class Projet2RefExperienceDAO
{
    private static $data  = null;

    public function __construct() {
        die('Init function is not allowed');
    }

    public static function create($idProject, $idExperience)
    {
        $log = Log::getLog();
        $pdo = Database::connect();
        $sql = "INSERT INTO projet2refexperience (id_projet, id_refexperience) 
            VALUES ( ? , ?)";
        $sth = $pdo->prepare($sql);
        if($sth->execute(array($idProject,$idExperience)))
            $log->info("Relation projet: ".$idProject." experience: ".$idExperience." créé!");
        else{
            $log->error("Echec de la creation de la relation projet: ".$idProject." experience: ".$idExperience." !");
            Database::disconnect();
            return 0;
        }   
        Database::disconnect();
        return 1;
    }

    public static function deleteByIdProject($idProject)
    {
        $log = Log::getLog();
        $pdo = Database::connect();
        $sql = "DELETE FROM projet2refexperience WHERE id_projet = ? ";
        $sth = $pdo->prepare($sql);
        if($sth->execute(array($idProject)))
            $log->info("Clean des relations projet: ".$idProject." !");
        Database::disconnect();
        return 1;
    }
    public static function isJoin($idProject, $idExperience)
    {
        $pdo = Database::connect();
        $sql = "SELECT id_projet FROM projet2refexperience WHERE id_projet = ? AND id_refexperience = ? LIMIT 1 ";
        $sth = $pdo->prepare($sql);
        $sth->execute(array($idProject,$idExperience));
        self::$data = $sth->fetch();
        Database::disconnect();
        if(self::$data == null)
            return 0;
        return 1;
    }

}
?>
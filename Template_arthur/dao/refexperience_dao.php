<?php
include_once(__DIR__.'/../database.php');
include_once(__DIR__.'/../log/log.php');
class RefExperienceDao
{   
    private static $data  = null;

    public function __construct() {
        die('Init function is not allowed');
    }

    public static function selectAll()
    {
        $pdo = Database::connect();
        $sql = 'SELECT id_refexperience, libelle_refexperience, commentaire_refexperience, 
            actif_refexperience, datecreation_refexperience FROM refexperience 
            ORDER BY id_refexperience DESC';
        self::$data = $pdo->query($sql);
        Database::disconnect();
        return self::$data;
    }

    public static function createRefExperience($libelle,$comment)
    {
        $log = Log::getLog();
        $actif = 1;
        $pdo = Database::connect();
        $sql = "INSERT INTO refexperience (libelle_refexperience, commentaire_refexperience, 
            actif_refexperience) 
            VALUES ( ? , ? , ?)";
        $req = $pdo->prepare($sql);
        if($req->execute(array($libelle, $comment, $actif)))
            $log->info("Création de l'experience ".$libelle.".");
        else{
            $log->error("Echec de la création de l'experience ".$libelle.".");
            Database::disconnect();
            return 0;
        }
        Database::disconnect();
        return 1;
    }
}
?>
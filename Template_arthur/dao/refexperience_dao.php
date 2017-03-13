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
    
    public static function selectAllActif()
    {
        $pdo = Database::connect();
        $sql = 'SELECT * FROM refexperience WHERE actif_refexperience = 1
            ORDER BY id_refexperience DESC';
        self::$data = $pdo->query($sql);
        Database::disconnect();
        return self::$data;
    }

    public static function getIdByActif()
    {
        $pdo = Database::connect();
        $sql = "SELECT id_refexperience FROM refexperience WHERE actif_refexperience = 1";
        $sth = $pdo->prepare($sql);
        $sth->execute();
        self::$data = $sth->fetch();
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

    public static function getLibelleActifById($id)
    {
        $pdo = Database::connect();
        $sql = "SELECT libelle_refexperience, actif_refexperience FROM refexperience WHERE id_refexperience = ? LIMIT 1 ";
        $sth = $pdo->prepare($sql);
        $sth->execute(array($id));
        self::$data = $sth->fetch();
        Database::disconnect();
        return self::$data;
    }

    public static function switchActif($id)
    {
        $log = Log::getLog();
        $pdo = Database::connect();
        $sql = "SELECT actif_refexperience FROM refexperience WHERE id_refexperience = ? LIMIT 1 ";
        $sth = $pdo->prepare($sql);
        $sth->execute(array($id));
        $actif = $sth->fetch();
        if($actif['actif_refexperience'] == 1){
            $sql = "UPDATE refexperience SET actif_refexperience = 0 WHERE id_refexperience = ?";
            $sth = $pdo->prepare($sql);
            if($sth->execute(array($id)))
                $log->info("L'experience ".$id." est maintenant inactif !");
            else{
                $log->error("Echec de l'inactivation de l'experience ".$id." !");
                Database::disconnect();
                return 0;
            }
        }
        else{
            $sql = "UPDATE refexperience SET actif_refexperience = 1 WHERE id_refexperience = ?";
            $sth = $pdo->prepare($sql);
            if($sth->execute(array($id)))
                $log->info("L'experience ".$id." est maintenant actif !");
            else{
                $log->error("Echec de l'activation de l'experience ".$id." !");
                Database::disconnect();
                return 0;
            }
        }
        Database::disconnect();
        return 1;
    }
}
?>
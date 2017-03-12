<?php
include_once(__DIR__.'/../database.php');
include_once(__DIR__.'/../log/log.php');
class ProjetDao
{   
    private static $data  = null;

    public function __construct() {
        die('Init function is not allowed');
    }

    public static function selectAll()
    {
        $pdo = Database::connect();
        $sql = 'SELECT id_projet, libelle_projet, commentaire_projet, actif_projet, datecreation_projet FROM projet ORDER BY id_projet DESC';
        self::$data = $pdo->query($sql);
        Database::disconnect();
        return self::$data;
    }

    public static function createProject($libelle,$comment)
    {
        $log = Log::getLog();
        $actif = 1;
        $pdo = Database::connect();
        $sql = "INSERT INTO projet (libelle_projet, commentaire_projet, 
            actif_projet) 
            VALUES ( ? , ? , ?)";
        $req = $pdo->prepare($sql);
        if($req->execute(array($libelle, $comment, $actif)))
            $log->info("Création du projet ".$libelle.".");
        else{
            $log->error("Echec de la création du projet ".$libelle.".");
            Database::disconnect();
            return 0;
        }
        Database::disconnect();
        return 1;
    }

    public static function getLibelleCommentaireActifById($id)
    {
        $pdo = Database::connect();
        $sql = "SELECT libelle_projet, commentaire_projet, actif_projet FROM projet WHERE id_projet = ? LIMIT 1 ";
        $sth = $pdo->prepare($sql);
        $sth->execute(array($id));
        self::$data = $sth->fetch();
        Database::disconnect();
        return self::$data;
    }

    public static function updateProject($id,$libelle,$comment,$actif)
    {
        $log = Log::getLog();
        $pdo = Database::connect();
        $sql = "UPDATE projet SET libelle_projet = ? , commentaire_projet = ? , actif_projet = ?  WHERE id_projet = ? ";
        $sth = $pdo->prepare($sql);
        if($sth->execute(array($libelle,$comment,$actif,$id))){
            $log->info("Mise a jour du projet ".$libelle.".");
        }
        else{
            $log->error("Echec de la mise a jour du projet ".$libelle.".");
            Database::disconnect();
            return 0;
        }

        Database::disconnect();
        return 1;
    }
}
?>
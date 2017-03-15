<?php
include_once(__DIR__.'/../service/database.php');
include_once(__DIR__.'/../log/log.php');
class RefTypeDonneeDao
{   
    private static $data  = null;

    public function __construct() {
        die('Init function is not allowed');
    }

    public static function selectAll()
    {
        $pdo = Database::connect();
        $sql = 'SELECT id_reftypedonnee, libelle_reftypedonnee, commentaire_reftypedonnee 
            FROM reftypedonnee ORDER BY id_reftypedonnee DESC';
        self::$data = $pdo->query($sql);
        Database::disconnect();
        return self::$data;
    }

    public static function createRefTypeDonnee($libelle,$comment)
    {
        $log = Log::getLog();
        $pdo = Database::connect();
        $sql = "INSERT INTO reftypedonnee (libelle_reftypedonnee, commentaire_reftypedonnee) 
            VALUES ( ? , ?)";
        $req = $pdo->prepare($sql);
        if($req->execute(array($libelle, $comment)))
            $log->info("Création du type de donnée ".$libelle.".");
        else{
            $log->error("Echec de la création du type de donnée ".$libelle.".");
            Database::disconnect();
            return 0;
        }
        Database::disconnect();
        return 1;
    }
}
?>
<?php
include_once(__DIR__.'/../database.php');
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
}
?>
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
}
?>
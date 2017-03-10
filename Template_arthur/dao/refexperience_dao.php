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
}
?>
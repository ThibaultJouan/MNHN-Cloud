<?php
include_once('database.php');
include_once(__DIR__.'/log/log.php');
class UtilisateurDao
{   
    private static $data  = null;

    public function __construct() {
        die('Init function is not allowed');
    }

    public static function selectAll()
    {
        $pdo = Database::connect();
        $sql = 'SELECT id_utilisateur, nom_utilisateur, prenom_utilisateur, mail_utilisateur, admin_utilisateur, actif_utilisateur, datecreation_utilisateur FROM utilisateur ORDER BY id_utilisateur DESC';
        self::$data = $pdo->query($sql);
        Database::disconnect();
        return self::$data;
    }

    public static function getNomPrenomActifById($id)
    {
        $pdo = Database::connect();
        $sql = "SELECT prenom_utilisateur, nom_utilisateur, actif_utilisateur FROM utilisateur WHERE id_utilisateur = ? LIMIT 1 ";
        $sth = $pdo->prepare($sql);
        $sth->execute(array($id));
        self::$data = $sth->fetch();
        Database::disconnect();
        return self::$data;
    }

    public static function switchActif($id)
    {
        $pdo = Database::connect();
        $sql = "SELECT actif_utilisateur FROM utilisateur WHERE id_utilisateur = ? LIMIT 1 ";
        $sth = $pdo->prepare($sql);
        $sth->execute(array($id));
        $actif = $sth->fetch();
        if($actif['actif_utilisateur'] == 1)
            $sql = "UPDATE utilisateur SET actif_utilisateur = 0 WHERE id_utilisateur = ?";
        else{
            $sql = "UPDATE utilisateur SET actif_utilisateur = 1 WHERE id_utilisateur = ?";
        }
        $sth = $pdo->prepare($sql);
        $sth->execute(array($id));
        Database::disconnect();
        return 1;
    }
}
?>
<?php
include_once(__DIR__.'/../database.php');
include_once(__DIR__.'/../log/log.php');
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
        $log = Log::getLog();
        $pdo = Database::connect();
        $sql = "SELECT actif_utilisateur FROM utilisateur WHERE id_utilisateur = ? LIMIT 1 ";
        $sth = $pdo->prepare($sql);
        $sth->execute(array($id));
        $actif = $sth->fetch();
        if($actif['actif_utilisateur'] == 1){
            $sql = "UPDATE utilisateur SET actif_utilisateur = 0 WHERE id_utilisateur = ?";
            $sth = $pdo->prepare($sql);
            if($sth->execute(array($id)))
                $log->info("L'utilisateur ".$id." est maintenant inactif !");
            else{
                $log->error("Echec de l'inactivation de l'utilisateur ".$id." !");
                Database::disconnect();
                return 0;
            }
        }
        else{
            $sql = "UPDATE utilisateur SET actif_utilisateur = 1 WHERE id_utilisateur = ?";
            $sth = $pdo->prepare($sql);
            if($sth->execute(array($id)))
                $log->info("L'utilisateur ".$id." est maintenant actif !");
            else{
                $log->error("Echec de l'activation de l'utilisateur ".$id." !");
                Database::disconnect();
                return 0;
            }
        }
        Database::disconnect();
        return 1;
    }

    public static function createUser($prenom,$nom,$email,$mdp)
    {
        $log = Log::getLog();
        $mdp_bdd = md5($mdp);
        $actif = 1;
        $admin = 0;
        $pdo = Database::connect();
        //Requette passe sur phpmyadmin mais pas ici ......
        $sql = "INSERT INTO utilisateur (nom_utilisateur, prenom_utilisateur, 
            mail_utilisateur, motdepasse_utilisateur, actif_utilisateur, admin_utilisateur) 
            VALUES (:nom, :prenom, :email, :mdp, :actif, :admin)";
        $req = $pdo->prepare($sql);
        $req->bindValue(':nom', $nom, PDO::PARAM_STR);
        $req->bindValue(':prenom', $prenom, PDO::PARAM_STR);
        $req->bindValue(':email', $email, PDO::PARAM_STR);
        $req->bindValue(':mdp', $mdp_bdd, PDO::PARAM_STR);
        $req->bindValue(':actif', $actif, PDO::PARAM_INT);
        $req->bindValue(':admin', $admin, PDO::PARAM_INT);
        if($req->execute()){
            $log->info("Création de l'utilisateur ".$prenom." ".$nom);
        }
        else{
            $log->error("Echec de la création de l'utilisateur ".$prenom." ".$nom);
            Database::disconnect();
            return 0;
        }
        Database::disconnect();
        return 1;
    }
}
?>
<?php
include_once(__DIR__.'/../service/database.php');
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

    public static function selectIdPrenomNomMailByActif()
    {
        $pdo = Database::connect();
        $sql = 'SELECT id_utilisateur, prenom_utilisateur, nom_utilisateur, mail_utilisateur FROM utilisateur WHERE actif_utilisateur = 1';
        self::$data = $pdo->query($sql);
        Database::disconnect();
        return self::$data;
    }

    public static function getIdByActif()
    {
        $pdo = Database::connect();
        $sql = "SELECT id_utilisateur FROM utilisateur WHERE actif_utilisateur = 1";
        self::$data = $pdo->query($sql);
        Database::disconnect();
        return self::$data;
    }

    public static function createUser($prenom,$nom,$mail,$mdp)
    {
        $log = Log::getLog();
        $actif = 1;
        $admin = 0;
        $pdo = Database::connect();
        $sql = "INSERT INTO utilisateur (nom_utilisateur, prenom_utilisateur, mail_utilisateur, motdepasse_utilisateur, actif_utilisateur, admin_utilisateur) VALUES ( ? , ? , ? , ? , ? , ? )";
        $req = $pdo->prepare($sql);
        if($req->execute(array($nom, $prenom, $mail, $mdp, $actif, $admin)))
            $log->info("Création de l'utilisateur ".$prenom." ".$nom);
        else{
            $log->error("Echec de la création de l'utilisateur ".$prenom." ".$nom);
            Database::disconnect();
            return 0;
        }
        Database::disconnect();
        return 1;
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

    public static function getNomPrenomMailMdpById($id)
    {
        $pdo = Database::connect();
        $sql = "SELECT prenom_utilisateur, nom_utilisateur, mail_utilisateur, motdepasse_utilisateur FROM utilisateur WHERE id_utilisateur = ? LIMIT 1 ";
        $sth = $pdo->prepare($sql);
        $sth->execute(array($id));
        self::$data = $sth->fetch();
        Database::disconnect();
        return self::$data;
    }

    public static function getIdByMail($mail)
    {
        $log = Log::getLog();
        $pdo = Database::connect();
        $sql = "SELECT id_utilisateur FROM utilisateur WHERE mail_utilisateur = ?  LIMIT 1 ";
        $sth = $pdo->prepare($sql);
        $sth->execute(array($mail));
        self::$data = $sth->fetch();
        Database::disconnect();
        return self::$data;
    }

	public static function updateUser($id,$nom,$prenom,$mail,$pwd)
	{
       $log = Log::getLog();
       $pdo = Database::connect();
       $sql = "UPDATE utilisateur SET motdepasse_utilisateur = ?, nom_utilisateur = ?, prenom_utilisateur = ?, mail_utilisateur = ? WHERE id_utilisateur = ?";
       $sth = $pdo->prepare($sql);
			if($sth->execute([$pwd,$nom,$prenom,$mail,$id]))
				$log ->info("Mot de passe updated pour l'utilisateur: ".$id);
			else{
				 $log ->error("Echec Mot de passe updated pour l'utilisateur: ".$id);
           Database::disconnect();
           return 0;
			}
       Database::disconnect();
       return 1;
	}

	public static function updatePwdUser($id,$pwd)
	{
       $log = Log::getLog();
       $pdo = Database::connect();
       $sql = "UPDATE utilisateur SET motdepasse_utilisateur = ? WHERE id_utilisateur = ?";
       $sth = $pdo->prepare($sql);
			if($sth->execute([$pwd,$id]))
				$log ->info("Mot de passe updated pour l'utilisateur: ".$id);
			else{
				 $log ->error("Echec Mot de passe updated pour l'utilisateur: ".$id);
           Database::disconnect();
           return 0;
			}
       Database::disconnect();
       return 1;
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

    public static function getIdNomPrenomActifAdminByMailMotdepasse($email,$mdp)
    {
		$log = log::getLog();
        $pdo = Database::connect();
        $sql = "SELECT prenom_utilisateur, nom_utilisateur, actif_utilisateur, admin_utilisateur, id_utilisateur FROM utilisateur WHERE mail_utilisateur = ? and motdepasse_utilisateur = ? LIMIT 1 ";
        $sth = $pdo->prepare($sql);
		$sth->execute(array($email,$mdp));
        self::$data = $sth->fetch();
		if(self::$data)
			$log ->info("Connection réussit avec l'email: ".$email);
		else
			$log ->info("Echec de la connection avec l'email: ".$email);
        Database::disconnect();
        return self::$data;
    }
}
?>

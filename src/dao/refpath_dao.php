<?php
include_once(__DIR__.'/../service/database.php');
include_once(__DIR__.'/../log/log.php');
class RefPathDao
{
    private static $data  = null;

    public function __construct() {
        die('Init function is not allowed');
    }

    public static function selectAll()
    {
        $pdo = Database::connect();
        $sql = 'SELECT id_refpath, libelle_refpath, path_refpath FROM refpath ORDER BY id_refpath DESC';
        self::$data = $pdo->query($sql);
        Database::disconnect();
        return self::$data;
    }

		public static function updateSrcPath($path)
		{
        $log = Log::getLog();
        $pdo = Database::connect();
        $sql = "UPDATE refpath SET path_refpath = ?  WHERE libelle_refpath = 'src' ";
        $sth = $pdo->prepare($sql);
        if($sth->execute(array($path))){
            $log->info("Mise a jour du  path src : ".$path.".");
        }
        else{
            $log->error("Echec de la mise a jour du path src ".$path.".");
            Database::disconnect();
            return 0;
        }
        Database::disconnect();
        return 1;
		}

		public static function getSrcPath()
		{
        $pdo = Database::connect();
        $sql = "SELECT path_refpath FROM refpath WHERE libelle_refpath = 'src' LIMIT 1 ";
        $sth = $pdo->prepare($sql);
        $sth->execute();
        self::$data = $sth->fetch();
        Database::disconnect();
        return self::$data;
		}
}

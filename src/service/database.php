<?php
include_once(__DIR__.'/../log/log.php');
class Database
{
    /**
    * Class staatic ici donc le logger doit etre inclus dans les methodes
    **/

    private static $dbName = 'MNHN' ;
    private static $dbHost = 'localhost' ;
    private static $dbUsername = 'root';
    private static $dbUserPassword = 'toor';

    private static $cont  = null;

    public function __construct() {
        die('Init function is not allowed');
    }

    public static function connect()
    {
       $log = Log::getLog();
       // One connection through whole application
       if ( null == self::$cont )
       {
        try
        {
          $log->debug("connection a la base de donnée !");
          self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword);
        }
        catch(PDOException $e)
        {
          $log->error("Connection a la base de donnée impossible : ".$e->getMessage());
          die($e->getMessage());
        }
       }
       return self::$cont;
    }

    public static function disconnect()
    {
        self::$cont = null;
    }
}
?>

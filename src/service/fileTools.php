<?php
include_once(__DIR__.'/../log/log.php');

class FileTools
{
		//Constructeur par default, n'est pas cense etre appele donc renvoie une erreur
    public function __construct() {
        die('Init function is not allowed');
    }

		//Cree le fichier dont le path est fourni en input
		public static function createFile($input){
			$ret = exec("touch " .$input, $out, $err);
		}

		//Supprime le fichier dont le path est fourni en input
		public static function deleteFile($input){
				$ret = exec("rm " .$input, $out, $err);
		}

		//Deplace ou renomme le fichier source, vers le fichier destination
		public static function moveFile($pathSource, $pathDestination){
				$ret = exec("mv " .$pathSource. " " .$pathDestination, $out, $err);
		}

		//Cree un repertoire dont le path est specifie en input
		public static function makeDirectory($path){
        $log = Log::getLog();
				$v = exec("mkdir " .$path ,$out, $err);
				if(exec("mkdir " .$path ,$out, $err))
					$log->info("Le dossier ".$path." a bien ete cree!");
				else
					$log->error("Le dossier ".$path." n'as pas pue etre cree!  : ");
		}

		//Supprime le repertoire fourni en input, ainsi que tout son contenu
		public static function deleteDirectory($input){
				$ret = exec("rm -rf " .$input, $out, $err);
		}
}
?>

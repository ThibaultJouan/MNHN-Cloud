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
			$log = Log::getLog();
			$ret = exec("touch \"" .$input."\"", $out, $err);
			if($err == 0)
				$log->info("Le fichier ".$input." a bien ete cree!");
			else
				$log->error("Le fichier ".$input." n'a pas pu etre cree!");
		}

		//Supprime le fichier dont le path est fourni en input
		public static function deleteFile($input){
			$log = Log::getLog();
			$ret = exec("rm \"" .$input."\"", $out, $err);
			if($err == 0)
				$log->info("Le fichier ".$input." a bien ete supprime!");
			else
				$log->error("Le fichier ".$input." n'a pas pu etre supprime!");
		}

		//Deplace ou renomme le fichier source, vers le fichier destination
		public static function moveFile($pathSource, $pathDestination){
			$log = Log::getLog();
			$ret = exec("mv \"" .$pathSource. "\" \"" .$pathDestination."\"", $out, $err);
			if($err == 0)
				$log->info("Le dossier ".$pathSource." a ete deplace vers ".$pathDestination."!");
			else
				$log->error("Le dossier ".$pathSource." n'a pas ete deplace vers ".$pathDestination."!");
		}

		//Cree un repertoire dont le path est specifie en input
		public static function makeDirectory($path){
			$log = Log::getLog();
			$ret = exec("mkdir \"" .$path."\"",$out, $err);
			if($err == 0)
				$log->info("Le dossier ".$path." a bien ete cree!");
			else
				$log->error("Le dossier ".$path." n'a pas pu etre cree!");
		}

		//Supprime le repertoire fourni en input, ainsi que tout son contenu
		public static function deleteDirectory($input){
			$log = Log::getLog();
			$ret = exec("rm -rf \"" .$input."\"", $out, $err);
			if($err == 0)
				$log->info("Le dossier ".$input." a bien ete supprime!");
			else
				$log->error("Le dossier ".$input." n'a pas pu etre supprime!");
		}
}
?>

<?php
include_once('../src/log/log.php');

class fileTools
{
    public function __construct() {
        die('Init function is not allowed');
    }

	public static function createFile($input){


			$ret = exec("touch " .$input, $out, $err);

		//exit(var_dump($variable));
		//Arrete l'execution et affiche la valeur de $variable

		//var_dump($ret);
		//var_dump($out);
		//var_dump($err);

	}

		public static function deleteFile($input){

				$ret = exec("rm " .$input, $out, $err);
		}

		public static function moveFile($pathSource, $pathDestination){

				$ret = exec("mv " .$pathSource. " " .$pathDestination, $out, $err);
		}

		public static function makeDirectory($path){

				$ret = exec("mkdir " .$path ,$out, $err);
		}

}
?>

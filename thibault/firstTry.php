<?php
include_once('../Template_arthur/log/log.php');

class fileTools
{
    public function __construct() {
        die('Init function is not allowed');
    }

	public static function createFile($Session, $input){


		if(true == $Session['Admin']){
			$ret = exec("touch " .$input, $out, $err);
		}

		//exit(var_dump($variable));
		//Arrete l'execution et affiche la valeur de $variable

		//var_dump($ret);
		//var_dump($out);
		//var_dump($err);

	}

		public static function deleteFile($Session, $input){

			if(true == $Session['Admin']){
				$ret = exec("rm " .$input, $out, $err);
			}
		}

		public static function moveFile($Session, $pathSource, $pathDestination){

			if(true == $Session['Admin']){
				$ret = exec("mv " .$pathSource. " " .$pathDestination, $out, $err);
			}
		}

		public static function makeDirectory($Session, $path){

			if(true == $Session['Admin']){
				$ret = exec("mkdir " .$path ,$out, $err);
			}
		}

}
?>

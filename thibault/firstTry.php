<?php

	function createFile($Session, $input){


		if(true == $Session['Admin']){
			$ret = exec("touch " .$input, $out, $err);
		}

		//exit(var_dump($variable));
		//Arrete l'execution et affiche la valeur de $variable

		//var_dump($ret);
		//var_dump($out);
		//var_dump($err);

	}

	function deleteFile($Session, $input){

			if(true == $Session['Admin']){
				$ret = exec("rm " .$input, $out, $err);
			}
		}

		function moveFile($Session, $pathSource, $pathDestination){

			if(true == $Session['Admin']){
				$ret = exec("mv " .$pathSource. " " .$pathDestination, $out, $err);
			}

		}

?>

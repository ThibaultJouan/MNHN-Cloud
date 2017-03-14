<?php
include_once 'firstry,php'
if(isset($_FILES["fichier"]["error"])){
    if($_FILES["fichier"]["error"] > 0){
        echo "Error: " . $_FILES["fichier"]["error"] . "<br>";
    } else{
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES["fichier"]["name"];
        $filetype = $_FILES["fichier"]["type"];
        $filesize = $_FILES["fichier"]["size"];

        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
				echo $ext;
        //if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");

				fileTools::makeDirectory(true, "upload");
        // Verify file size - 5MB maximum
        /*$maxsize = 5 * 1024 * 1024;
        if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");
				 */
        // Verify MYME type of the file
        if(in_array($filetype, /*$allowed*/)){
            // Check whether file exists before uploading it
            if(file_exists( "./upload/ " .$_FILES["fichier"]["name"])){
                echo "./upload/" .$_FILES["fichier"]["name"] . " existe deja.";
            } else{
							move_uploaded_file($_FILES["fichier"]["tmp_name"],
										 "./upload/" .$_FILES["fichier"]["name"]);
                echo "Your file was uploaded successfully.";
            }
        } else{
            echo "Une erreur est survenue pendant l'upload du fichier";
        }
    }
} else{
    echo "Error: Invalid parameters - please contact your server administrator.";
}
?>

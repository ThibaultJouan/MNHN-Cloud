<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<?php
		session_start();

		include_once(__DIR__.'/../../service/configPath.php');
		include_once(__DIR__.'/../../service/fileTools.php');
		include_once(__DIR__.'/../../dao/projet_dao.php');
		include_once(__DIR__.'/../../dao/refexperience_dao.php');
		include_once(__DIR__.'/../../dao/refexperience_dao.php');

		$path = PATH_PROJET;

		$id_projet = $_GET['projet'];
		$id_exp = $_GET['exp'];
		$section = $_GET['section'];

		$row = ProjetDao::getLibelleById($id_projet);
		$libelleProjet = $row['libelle_projet'];
		$pathProjet = $path.$libelleProjet;
		$row = RefExperienceDao::getLibelleActifById($id_exp);
		$libelleExperience = $row['libelle_refexperience'];
		$pathExperience = $pathProjet.'/'.$libelleExperience;
		$directory = openDir($pathExperience.'/'.$section);

		while($entryName = readdir($directory)) {
			$dirArray[] = $entryName;
		}

		closedir($directory);


		echo '<title>'.$libelleExperience.'</title>';

		?>
		<link rel="icon" type="image/png" href="../../../img/logo/logo_MNHN.png" />

		<!-- CSS -->
		<link href="../../../css/bootstrap.min.css" rel="stylesheet">
		<link href="../../../css/basdepage.css" rel="stylesheet">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

	</head>

	<body class="container">

	<h1><?php echo $section?></h1>
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>Libellé</th>
          <th>Commentaire</th>
          <th>Actif</th>
        </tr>
      </thead>
      <tbody>

		<?php
		$indexCount	= count($dirArray);
		// loop through the array of files and print them all
		for($index=0; $index < $indexCount; $index++) {
			if (substr("$dirArray[$index]", 0, 1) != "."){ // don't list hidden files
				print("<TR><TD><a href=\"./../../../../MNHN-Cloud/src/service/uploadManager.php?projet=$id_projet&exp=$id_exp&section=$section&fileName=$dirArray[$index]\">$dirArray[$index]</a></td>");
				print("<td>");
				print(filetype($pathExperience.'/'.$section.'/'.$dirArray[$index]));
				print("</td>");
				print("<td>");
				print(FileTools::humanReadableSize(filesize($pathExperience.'/'.$section.'/'.$dirArray[$index])));
				print("</td>");
				print("</TR>\n");
			}
		}
		print("</TABLE>\n");

			echo '<form method="post" action="../../service/downloadManager.php" enctype="multipart/form-data">';
			echo '<input type="hidden" name="id_projet" value="'.$id_projet.'">';
			echo '<input type="hidden" name="id_exp" value="'.$id_exp.'">';
			echo '<input type="hidden" name="section" value="'.$section.'">';
			echo '<input type="file" name="nom_du_fichier">';
			echo '<input type="submit" value="Envoyer">';
			echo '</form>';

		?>
      </tbody>
    </table>
    <!--Fin Module ref experience -->

	</body>
</html>

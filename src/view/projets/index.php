<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<?php
		session_start();

		include_once (__DIR__.'/../../dao/utilisateur_dao.php');
		include_once (__DIR__.'/../../dao/projet_dao.php');
		include_once (__DIR__.'/../../dao/refexperience_dao.php');
		include_once (__DIR__.'/../../dao/projet_utilisateur_dao.php');
		include_once (__DIR__.'/../../dao/projet_refexperience_dao.php');

		//ajout de ALO
		$id_project = $_GET["id"];
		$id_utilisateur = $_SESSION['id_utilisateur'];

		if(Projet2UtilisateurDao::contains($id_project, $id_utilisateur)  !=1 && $_SESSION['admin'] != 1){
			header('Location: ' . '../../index.php');
		}
		?>

			<title><?php $row = ProjetDao::getLibelleById($id_project);
			echo $row['libelle_projet'];
			?></title>

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
		<header class="row">
			<div class="col-xs-12">
				<center>
					<h1>Projets</h1>
				</center>
			</div>
			<div class="row">
				<div class="col-md-offset-3 col-md-6">
					<hr class="primary">
				</div>
			</div>

		<?php include (__DIR__.'/../../navbar.html')?>
		</header>
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>Libellé</th>
          <th>Commentaire</th>
          <th>Actif</th>
          <th>Date creation</th>
          <th>Acces aux donnees</th>
        </tr>
      </thead>
      <tbody>
				<?php
				$row = ProjetDao::getLibelleById($id_project);
					//if($row['id_projet'] == $id_project) {
						echo '<h1>'. $row['libelle_projet'] .'</h1>';
						echo '<h3>Experiences : </h3>';
						foreach(RefExperienceDao::selectAllActif() as $exp) {
							if(1 == Projet2RefExperienceDao::isJoin($id_project, $exp['id_refexperience'])){
								echo '<tr>';
								echo '<td>'. $exp['libelle_refexperience'] . '</td>';
								echo '<td>'. $exp['commentaire_refexperience'] . '</td>';
								echo '<td>'. $exp['actif_refexperience'] . '</td>';
								echo '<td>'. $exp['datecreation_refexperience'] . '</td>';
								echo '<td>';
								echo '<a class="btn btn-success btn-sm" href="../experience/index.php?projet='.$id_project.'&exp='.$exp['id_refexperience'].'&section=Force">Force</a>';
								echo '<a class="btn btn-success btn-sm" href="../experience/index.php?projet='.$id_project.'&exp='.$exp['id_refexperience'].'&section=Pression">Pression</a>';
								echo '<a class="btn btn-success btn-sm" href="../experience/index.php?projet='.$id_project.'&exp='.$exp['id_refexperience'].'&section=Video">Video</a>';
								echo '</td>';
								echo '</tr>';
							}
						}


					//break;
					//}

				?>
      </tbody>
    </table>

<?php
						if(Projet2UtilisateurDao::isChefProjet($id_project, $id_utilisateur) == 1
							|| $_SESSION['admin'] == 1){
							echo "<h3>ajouter une experience</h3>";
							echo '<form method="post" action="../../service/cdpAjoutExperience.php">';
							echo '<input type="hidden" name="idProject" value="'.$id_project.'"/>';
							echo '<input type="text" name="libelleExp" />';
							echo '<input type="text" name="commentaireExp" />';
							echo '<button type="submit" class="btn btn-success btn-sm" >Créer experience</button>';
							echo '</form>';
						}
?>
    <!--Fin Module ref experience -->

	</body>
</html>

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
		include_once (__DIR__.'/../../dao/reftypedonnee_dao.php');
		include_once (__DIR__.'/../../dao/projet_utilisateur_dao.php');
		include_once (__DIR__.'/../../dao/projet_refexperience_dao.php');
		
		//ajout de ALO
		$id_project = $_GET["id"];
		
		if(Projet2UtilisateurDAO::isJoin($id_project, $_SESSION['id_utilisateur']) !=1){
			header('Location: ' . '../../index.php');
		}
		?>

		<title>Vue projet</title>

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
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>Libellé</th>
          <th>Commentaire</th>
          <th>Actif</th>
          <th>Date creation</th>
        </tr>
      </thead>
      <tbody>
				<?php
				foreach(ProjetDao::selectAll() as $row) {
					if($row['id_projet'] == $id_project) {
						echo '<h1>'. $row['libelle_projet'] .'</h1>';
						echo '<h3>Experiences : </h3>';
						foreach(RefExperienceDao::selectAllActif() as $exp) {
							if(1 == Projet2RefExperienceDAO::isJoin(1, 1)){
								echo '<tr>';
								echo '<td>'. $exp['libelle_refexperience'] . '</td>';
								echo '<td>'. $exp['datecreation_refexperience'] . '</td>';
								echo '<td>'. $exp['commentaire_refexperience'] . '</td>';
								echo '<td>';
								echo '<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#" data-id="'.$exp['id_refexperience'].'">Faire quelque chose</a>';
								echo '</td>';
								echo '</tr>';
							}
						}
						break;
					}
				}
				?>
      </tbody>
    </table>
    <!--Fin Module ref experience -->
	</body>
</html>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<?php
			session_start();
			if(!isset($_SESSION['id_utilisateur'])){
				header('Location: ' . '../view/connection');
			}	
		?>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>MNHN Cloud</title>

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
		
		<?php include_once (__DIR__.'/../../dao/donnee_dao.php'); ?>
		
		<!-- Modal -->
		<?php include './modal/edit-pdw-user.html';?>
			
    </head>
    <body class="container">
		<header class="row">
			<div class="col-xs-12">
				<center>
					<h1><?php echo $_SESSION['prenom'].' '.$_SESSION['nom']; ?></h1>	
				</center>
			</div>
		</header>
		<hr class="primary">
		<section class="row">
			<div class="col-xs-2 col-xs-offset-10">
				<div class="btn-group">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Option <span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<li><a  data-toggle="modal" data-target="#edit-pwd-user" data-id="<?php echo $_SESSION['id_utilisateur']; ?>">Changer le mots de passe</a></li>
						<li><a href="..\..\service\deconnexion.php">Déconnexion</a></li>
					</ul>
				</div>
			</div>		
		</section>
		
		<section class="row">
			<div class="col-md-12">
				<h2>5 dernière MaJ</h2>
				<br class="primary">
				<div class="row">
					<div class="col-md-10 col-lg-offset-1">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Nom projet</th>
									<th>Nom refexperience</th>
									<th>Nom fichier</th>
									<th>Utilisateur</th>
									<th>Date</th>
								</tr>
							</thead>
							<?php
								foreach(DonneeDao::cinqDerniereMAJByIdUtilisateur($_SESSION['id_utilisateur']) as $row){
							?>
							<tbody>
								<tr>
									<td><?php echo $row['libelle_projet'];?></td>
									<td><?php echo $row['libelle_refexperience'];?></td>
									<td><?php echo $row['nomfichier_donnee'];?></td>
									<td><?php echo $row['prenom_utilisateur'].' '.$row['nom_utilisateur'];?></td>
									<td><?php echo $row['datecreation_donnee'];?></td>
								</tr>
							</tbody>
							<?php
								}
							?>
						</table>
					</div>
				</div>
			</div>
		</section>
		
		<!-- jQuery -->
		<script src="../../../js/jquery-3.1.1.min.js"></script>
		<!-- bootstrap js -->
		<script src="../../../js/bootstrap.min.js"></script>
		
    </body>	
</html>
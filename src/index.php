<!DOCTYPE html>
<html lang="fr">
	<head>
	    <?php
			session_start();
			if(!isset($_SESSION['id_utilisateur'])){
				header('Location: ' . './view/connection');
			}
		?>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>MNHN Cloud</title>

		<link rel="icon" type="image/png" href="../img/logo/logo_MNHN.png" />

		<!-- CSS -->
		<link href="../css/bootstrap.min.css" rel="stylesheet">
		<link href="../css/basdepage.css" rel="stylesheet">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

		<?php include_once (__DIR__.'/dao/projet_dao.php'); ?>
		<?php include_once (__DIR__.'/dao/projet_utilisateur_dao.php'); ?>

	</head>
	<body class="container">

		<header>
			<div class="row">
				<div class="col-md-12">
					<center>
					<h1>MNHN Cloud</h1>
					</center>
				</div>
			</div>
			<div class="row">
				<div class="col-md-offset-3 col-md-6">
					<hr class="primary">
				</div>
			</div>


			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="">MNHN Cloud</a>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">
							<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Liste projet <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<?php
								foreach(ProjetDao::selectAll() as $row){
									if(Projet2UtilisateurDao::isJoin($row['id_projet'], $_SESSION['id_utilisateur']) == 1
										|| $_SESSION['admin'] == 1){
										?>
										<li><a href="view/projets/index.php?id=<?php echo $row['id_projet']?> "> <?php echo $row['libelle_projet']; ?> </a><li>
										<?php
									}
								}?>

							</ul>
							</li>
						</ul>
						<!-- à afficher en fonction du type de profile -->
						<ul class="nav navbar-nav navbar-right">
							<?php if($_SESSION ['admin'] == 1){
								echo '<li><a href="view\admin">Admin</a></li>';
							}?>
							<!-- à mofifier en foncion de la connection -->
							<li><a href="view\profile"><?php echo $_SESSION['prenom'].' '.$_SESSION['nom']; ?></a></li>
							<li><a href="service\deconnexion.php">Déconnexion</a></li>
						</ul>
					</div>
				</div>
			</nav>
		</header>

		<section class="row">

			<div class="col-md-4">

			</div>
			<div class="col-md-8">

			</div>

		</section>

		<footer class="row">
			<div class="col-lg-offset-1 col-lg-10">
				<p class="navbar-text pull-left">© 2017 - V 0.1</p>
			</div>
		</footer>

		<!-- jQuery -->
		<script src="../js/jquery-3.1.1.min.js"></script>
		<!-- bootstrap js -->
		<script src="../js/bootstrap.min.js"></script>
	</body>
</html>

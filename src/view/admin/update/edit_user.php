<html>
<head>
    <script src="../../../js/jquery-3.1.1.min.js"></script>
</head>
<body>
		<?php
		session_start();
		if($_SESSION ['admin'] != 1){
			header('Location: ' . '../../../index.php');
			exit();
		}
		include_once (__DIR__.'/../../../dao/utilisateur_dao.php');
		if($_POST['rowid']) {
			$id = $_POST['rowid'];
			$utilisateur = UtilisateurDao::getNomPrenomMailMdpById($id);
    ?>
    <div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="call-to-action">
					<div class="service-box">
						<form class="form" id="formPwdUser" method="post" action="../../service/admin/edit_user_bdd.php">
							<p class="text-muted">Mot de passe</p>
							<div class="row">
								<div class="col-md-5">
									<?php
									echo '<input type="hidden" class="form-control " name="idUser" value = "'.$id.'" form="formPwdUser"/>';

									echo '<p class="text-muted">Nom</p>';
									echo '<input class="form-control " name="nomUser" value = "'.$utilisateur['nom_utilisateur'].'" form="formPwdUser"/>';

									echo '<p class="text-muted">Prenom</p>';
									echo '<input class="form-control " name="prenomUser" value = "'.$utilisateur['prenom_utilisateur'].'" form="formPwdUser"/>';

									echo '<p class="text-muted">Mail</p>';
									echo '<input class="form-control " name="mailUser" value = "'.$utilisateur['mail_utilisateur'].'" form="formPwdUser"/>';

									echo '<p class="text-muted">Mot de passe</p>';
									echo '<input type="password" class="form-control " name="pwdUser" value = "'.$utilisateur['motdepasse_utilisateur'].'" form="formPwdUser"/>';

										?>
								</div>
							</div>
						</form>
					</div>
				</div>
			 </div>
		</div>
		<br/>
		<br/>
		<div class="row">
			<div class = 'col-md-12'>
				<button type="submit" form="formPwdUser" class="btn btn-success" href="../../service/admin/edit_user_bdd.php">Mise a jour</button>
				<a href="index.php" class="btn btn-warning">Annule</a>
			</div>
		</div>
    </div>
    <?php
		}
    ?>
</body>
</html>

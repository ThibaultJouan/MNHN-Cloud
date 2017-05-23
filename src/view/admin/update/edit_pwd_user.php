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
			$row = UtilisateurDao::getNomPrenomMailMdpById($id);
    ?>
    <div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="call-to-action">
					<div class="service-box">
						<form class="form" id="formPwdUser" method="post" action="../../service/admin/edit_pwd_user_bdd.php">
							<?php
								echo	'<p class="text-muted">Edition du compte de '.$row['prenom_utilisateur'].' '.$row['nom_utilisateur'].'</p>';
							?>
							<div class="row">
								<div class="col-md-5">
									<?php
									echo '<input type="hidden" class="form-control " name="idUser" value = "'.$id.'" form="formPwdUser"/>';

									echo '<input type="password" class="form-control " name="pwdUser" value = "'.$row['motdepasse_utilisateur'].'" form="formPwdUser"/>';
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
				<button type="submit" form="formPwdUser" class="btn btn-success" href="../../service/admin/edit_pwd_user_bdd.php">Mise a jour</button>
				<a href="index.php" class="btn btn-warning">Annule</a>
			</div>
		</div>
    </div>
    <?php
		}
    ?>
</body>
</html>

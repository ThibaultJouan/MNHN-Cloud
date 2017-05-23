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
			<div class="col-xs-12">

			
			<div class="btn-group">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Option <span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<li><a  data-toggle="modal" data-target="#edit-pwd-user" data-id="<?php echo $_SESSION['id_utilisateur']; ?>">Changer le mots de passe</a></li>
				</ul>
			</div>
			
			
			
			
			</div>		
		</section>
		
		

		
		
		
		<!-- jQuery -->
		<script src="../../../js/jquery-3.1.1.min.js"></script>
		<!-- bootstrap js -->
		<script src="../../../js/bootstrap.min.js"></script>

	
	<!-- Edit pwd user-->
    <div class="modal fade" id="edit-pwd-user" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Changer mot de passe utilisateur</h4>
          </div>
          <div class="modal-body">
            
			
									<form class="form" id="formPwdUser" method="post" action="../../service/admin/edit_pwd_user_bdd.php">
							<?php
								echo	'<p class="text-muted">Nouveau mot de passe de '.$row['prenom_utilisateur'].' '.$row['nom_utilisateur'].'</p>';
							?>
							<div class="row">
								<div class="col-md-5">
									<?php
									echo '<input type="hidden" class="form-control " name="idUser" value = "'.$id.'" form="formPwdUser"/>';
									?>
									<input type="password" class="form-control " name="pwdUser" value = "MNHN-Could" form="formPwdUser"/>
								</div>
							</div>
						</form>
			
			
          </div>
        </div>
      </div>
    </div>
    <!-- Fin edit pwd user-->
    </body>
</html>
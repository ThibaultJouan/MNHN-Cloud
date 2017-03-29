<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	
		<title>MNHN Cloud</title>

		<!-- CSS -->
		<link href="../../../css/bootstrap.min.css" rel="stylesheet">
		<link href="../../../css/basdepage.css" rel="stylesheet">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		
		<?php 
			$immage = rand(1, 15);
		?>
		<style>
		body {
			background: #252525;
			font-weight: 300;
		}
		.main {
			background: white url(../../../img/connection/<?php echo $immage; ?>.jpg) right top no-repeat;
			background-size: contain;
			padding: 80px 20px 20px;
			margin-top: 120px;
		}
		@media only screen and (max-width : 992px) {
		.main {
			background: white;
			margin-top: 30px;
		}
		</style>	
    </head>
    <body class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="main">
					<div class="row">
					<div class="col-xs-12 col-sm-6 col-sm-offset-1">
						<h1>MNHN Cloud</h1>
						<h2>Connection</h2>
						<br>
						<form action="./../../service/connection.php" name="login" role="form" class="form-horizontal" method="post" accept-charset="utf-8">
							<div class="form-group">
							<div class="col-md-8"><input name="emailConn" placeholder="Mail" class="form-control" type="email" required></div>
							</div> 
							<div class="form-group">
							<div class="col-md-8"><input name="mdpConn" placeholder="Mot de passe" class="form-control" type="password" required></div>
							</div> 
							<div class="form-group">
							<div class="col-md-offset-0 col-md-8"><input  class="btn btn-success btn btn-success" type="submit" value="Connexion"/></div>
							</div>
						</form>
					</div>
					</div>	
				</div>
			</div>
		</div>
		
		<!-- jQuery -->
		<script src="../js/jquery-3.1.1.min.js"></script>
		<!-- bootstrap js -->
		<script src="../js/bootstrap.min.js"></script>
    </body>
</html>
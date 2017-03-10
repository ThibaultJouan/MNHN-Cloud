<!DOCTYPE html>
<html lang="fr">
<head>
  <title>Creation utilisateur</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="call-to-action">
		    <div class="service-box">
			    <form class="form-inscription" id="formInscr" method="post" action="create_user_bdd.php">
					<h3>Créé utilisateur</h3>
					<div class="service-box">
						<p class="text-muted">Nom *</p>
						<input type="nom" class="form-control" placeholder="Nom"
							name="nomInscr" pattern="[A-Za-z]{2,40}">
					</div>
					<div class="service-box">
						<p class="text-muted">Prénom *</p>
						<input type="prenom" class="form-control" placeholder="Prénom"
							name="prenomInscr" pattern="[A-Za-z]{2,40}">
					</div>
                    <div class="service-box">
						<p class="text-muted">E-Mail *</p>
						<input type="mail" class="form-control" placeholder="Ex : exemple@aevasion.com"
                            name="emailInscr" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
					</div>
                    <div class="service-box">
                        <p class="text-muted">Mot de passe par défaut</p>
                        <input type="mdp" class="form-control" value="MNHN-Cloud"
                            name="mdpInscr" readonly>
                    </div>
				</form>

			</div>
        </div>
        <br/>
        <br/>
        <div class="row">
            <div class = 'col-md-3'>
                <button type="submit" form="formInscr"
		            class="btn btn-success"
			        href="create_user_bdd.php">Créé</button>
            </div>
            <div class = 'col-md-3'>
                <p>
                    <a href="admin.php" class="btn btn-warning">Annule</a>
                </p>
            </div>  
        </div>

    </div>
</body>
</html>
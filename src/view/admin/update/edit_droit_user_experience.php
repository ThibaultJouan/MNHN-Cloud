<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Droits sur les experiences</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../../../../css/bootstrap.min.css">
        <script src="../../../../js/jquery-3.1.1.min.js"></script>
        <script src="../../../../js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php
 				session_start();
				if($_SESSION ['admin'] != 1){
					header('Location: ' . '../../../index.php');
					exit();
				}
 				include_once (__DIR__.'/../../../dao/utilisateur_dao.php');
 				include_once (__DIR__.'/../../../dao/projet_utilisateur_dao.php');
        include_once (__DIR__.'/../../../dao/projet_dao.php');
        include_once (__DIR__.'/../../../dao/projet_refexperience_dao.php');
        include_once (__DIR__.'/../../../dao/refexperience_dao.php');
        include_once (__DIR__.'/../../../dao/refexperience_utilisateur_dao.php');
        if($_GET['idUser'] && $_GET['idProject']) {
        ?>
        <div class="container">
            <?php
            $idUser = $_GET['idUser'];
						$idProject = $_GET['idProject'];
            $user = UtilisateurDao::getNomPrenomActifById($idUser);
						$project = ProjetDao::getLibelleById($idProject);
						echo "<h1>Droits de l'utilisateur: ".$user['prenom_utilisateur'].' '.$user['nom_utilisateur'].'</h1>';
						echo '<h1>Sur le projet: '.$project['libelle_projet'].'</h1>';
            ?>
            </br>
            <h2>Experiences:</h2>
            <form class="form" id="formDroitUser" method="post" action="../../../service/admin/edit_droits_user_experience_bdd.php">
                <?php
                echo '<input type="HIDDEN" name="idUser" value="'.$idUser.'">';
                ?>
            </form>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nom de l'expérience</th>
                        <th>Droits pour déposer des fichiers</th>
                    </tr>
                </thead>
                <tbody>
					<?php
                    foreach(Projet2RefExperienceDao::selectAllByIdProjet($idProject) as $row){
											$libelleExp = RefExperienceDao::getLibelleActifById($row['id_refexperience']);
											echo "<tr><td>".$libelleExp['libelle_refexperience']."</td>";
											echo "<td>";
											$contain = RefExperience2UtilisateurDao::contains($idUser,$row['id_refexperience']);
											if($contain == 0){
												echo '<input type="checkbox" name="'.$row['id_refexperience'].'" value="yes" form="formDroitUser">Autorisé';
											}	else{
												echo '<input type="checkbox" name="'.$row['id_refexperience'].'" value="yes" form="formDroitUser" checked>Autorisé';
											}
											echo "</td></tr>";
										}
					?>
                </tbody>
            </table>
            <div class="row">
                <div class = 'col-md-2'>
                    <button type="submit" form="formDroitUser" class="btn btn-success"
			            href="../../../service/admin/edit_droits_user_experience_bdd.php">Mise à jour</button>
                </div>
                <div class = 'col-md-2'>
                    <p>
                        <a href="../index.php" class="btn btn-warning">Annuler</a>
                    </p>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </body>
</html>

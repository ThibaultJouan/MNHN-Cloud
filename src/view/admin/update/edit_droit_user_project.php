<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Droits sur les projets affecter</title>
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
        if($_GET['idUser']) {
        ?>
        <div class="container">
            <?php
            $idUser = $_GET['idUser'];
            $user = UtilisateurDao::getNomPrenomActifById($idUser);
            echo "<h1>Droits de l'utilisateur: ".$user['nom_utilisateur'].' '.$user['prenom_utilisateur'].'</h1>';
            ?>
            </br>
            <h2>Projets:</h2>
            <form class="form" id="formDroitUser" method="post" action="../../../service/admin/edit_droits_user_project_bdd.php">
                <?php
                echo '<input type="HIDDEN" name="idUser" value="'.$idUser.'">';
                ?>
            </form>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nom du projet</th>
                        <th>Droits pour déposer des fichiers</th>
                        <th>Droits sur les expériences</th>
                    </tr>
                </thead>
                <tbody>
					<?php
                    foreach(Projet2UtilisateurDao::selectAllByIdUser($idUser) as $row){
												$libelleProjet = ProjetDao::getLibelleById($row['id_projet']);
                        echo '<tr>';
												echo '<td><label>'. $libelleProjet['libelle_projet']. '</label></td>';
                        echo '<td>';
                        if($row['chef_projet'] == 0){
                            echo '<input type="checkbox" name="'.$row['id_projet'].'" value="yes" form="formDroitUser">Autorisé';
                        }
                        else{
                            echo '<input type="checkbox" name="'.$row['id_projet'].'" value="yes" form="formDroitUser" checked>Autorisé';
                        }
                        echo '</td>';
												echo '<td>';
												echo '<a class="btn btn-success" href="./edit_droit_user_experience.php?idUser='.$idUser.'&idProject='.$row['id_projet'].'">Expériences</a>';
												echo '</td>';
                        echo '</tr>';
                    }
					?>
                </tbody>
            </table>
            <div class="row">
                <div class = 'col-md-2'>
                    <button type="submit" form="formDroitUser" class="btn btn-success"
			            href="../../../service/admin/edit_droits_user_project_bdd.php">Mise à jour</button>
                </div>
                <div class = 'col-md-2'>
                    <p>
                        <a href="../index.php" class="btn btn-warning">Annule</a>
                    </p>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </body>
</html>

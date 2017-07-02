
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Liaison utilisateur projets</title>
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
			include_once (__DIR__.'/../../../dao/projet_dao.php');
      include_once (__DIR__.'/../../../dao/utilisateur_dao.php');
      include_once (__DIR__.'/../../../dao/projet_utilisateur_dao.php');
      if($_POST['idUser']) {
		?>
		<div class="container">
            <?php
            $id = $_POST['idUser'];
            $user = UtilisateurDao::getNomPrenomMailMdpById($id);
            echo "<h1>Projets à lier a l'utilisateur: ".$user['prenom_utilisateur'].' '.$user['nom_utilisateur'].'</h1>';
            ?>
            </br>
            <h2>Projets:</h2>
            <form class="form" id="formUtilisateur2Projet" method="post" action="../../../service/admin/edit_user2project_bdd.php">
                <?php
                echo '<input type="HIDDEN" name="idUser" value="'.$id.'">';
                ?>
            </form>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Projet</th>
                        <th>Affecter</th>
                    </tr>
                </thead>
                <tbody>
					<?php
                    foreach(ProjetDao::selectIdLibelleByActif() as $row){
                        echo '<tr>';
                        echo '<td>'. $row['libelle_projet'] . '</td>';
                        echo '<td>';
                        if(Projet2UtilisateurDao::contains($row['id_projet'], $id) == 0){
                            echo '<label><input type="checkbox" name="'.$row['id_projet'].'" value="yes" form="formUtilisateur2Projet">Lié</label>';
                        }
                        else{
                            echo '<label><input type="checkbox" name="'.$row['id_projet'].'" value="yes" form="formUtilisateur2Projet" checked>Lié</label>';
                        }
                        echo '</td>';
                        echo '</tr>';
                    }
					?>
                </tbody>
            </table>
            <div class="row">
                <div class = 'col-md-2'>
                    <button type="submit" form="formUtilisateur2Projet" class="btn btn-success"
			            href="../../../service/admin/edit_user2project_bdd.php">Ajout des droits</button>
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

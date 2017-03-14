<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Liaison projet utilisateur</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php
        include_once (__DIR__.'/dao/projet_dao.php');
        include_once (__DIR__.'/dao/utilisateur_dao.php');
        include_once (__DIR__.'/dao/projet_utilisateur_dao.php');
        if($_POST['idProject']) {
        ?>
        <div class="container">
            <?php
            $id = $_POST['idProject'];
            $projet = ProjetDao::getLibelleById($id);
            echo '<h1>Utilisateurs à lier au projet: '.$projet['libelle_projet'].'</h1>';
            ?>
            </br>
            <h2>Utilisateurs:</h2>
            <form class="form" id="formProject2Utilisateur" method="post" action="edit_project2user_bdd.php">
                <?php
                echo '<input type="HIDDEN" name="idProject" value="'.$id.'">';
                ?>
            </form>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Prenom</th>
                        <th>Nom</th>
                        <th>Mail</th>                
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach(UtilisateurDao::selectIdPrenomNomMailByActif() as $row){
                        echo '<tr>';
                        echo '<td>'. $row['prenom_utilisateur'] . '</td>';
                        echo '<td>'. $row['nom_utilisateur'] . '</td>';
                        echo '<td>'. $row['mail_utilisateur'] . '</td>';
                        echo '<td>';
                        if(Projet2UtilisateurDAO::isJoin($id, $row['id_utilisateur']) == 0){
                            echo '<label><input type="checkbox" name="'.$row['id_utilisateur'].'" value="yes" form="formProject2Utilisateur">Lié</label>';
                        }
                        else{
                            echo '<label><input type="checkbox" name="'.$row['id_utilisateur'].'" value="yes" form="formProject2Utilisateur" checked>Lié</label>';
                        }
                        echo '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
            <div class="row">
                <div class = 'col-md-2'>
                    <button type="submit" form="formProject2Utilisateur" class="btn btn-success"
			            href="edit_project2user_bdd.php">Mise a jour</button>
                </div>
                <div class = 'col-md-2'>
                    <p>
                        <a href="admin.php" class="btn btn-warning">Annule</a>
                    </p>
                </div>  
            </div>
        </div>
        <?php
        }
        ?>
    </body>
</html>
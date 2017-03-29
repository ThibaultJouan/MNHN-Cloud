<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Liaison projet experience</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../../../../css/bootstrap.min.css">
        <script src="../../../../js/jquery-3.1.1.min.js"></script>
        <script src="../../../../js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php
        include_once (__DIR__.'/../../../dao/projet_dao.php');
        include_once (__DIR__.'/../../../dao/refexperience_dao.php');
        include_once (__DIR__.'/../../../dao/projet_refexperience_dao.php');
        if($_POST['idProject']) {
        ?>
        <div class="container">
            <?php
            $id = $_POST['idProject'];
            $projet = ProjetDao::getLibelleById($id);
            echo '<h1>Expériences à lier au projet: '.$projet['libelle_projet'].'</h1>';
            ?>
            </br>
            <h2>Experiences:</h2>
            <form class="form" id="formProject2Experience" method="post" action="../../../service/admin/edit_project2experience_bdd.php">
                <?php
                echo '<input type="HIDDEN" name="idProject" value="'.$id.'">';
                ?>
            </form>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Commentaire</th>
                        <th>Date creation</th>                
                    </tr>
                </thead>
                <tbody>
					<?php
                    foreach(RefExperienceDao::selectAllActif() as $row){
                        echo '<tr>';
                        echo '<td>'. $row['libelle_refexperience'] . '</td>';
                        echo '<td>'. $row['commentaire_refexperience'] . '</td>';
                        echo '<td>'. $row['datecreation_refexperience'] . '</td>';
                        echo '<td>';
                        if(Projet2RefExperienceDAO::isJoin($id, $row['id_refexperience']) == 0){
                            echo '<label><input type="checkbox" name="'.$row['id_refexperience'].'" value="yes" form="formProject2Experience">Lié</label>';
                        }
                        else{
                            echo '<label><input type="checkbox" name="'.$row['id_refexperience'].'" value="yes" form="formProject2Experience" checked>Lié</label>';
                        }
                        echo '</td>';
                        echo '</tr>';
                    }
					?>
                </tbody>
            </table>
            <div class="row">
                <div class = 'col-md-2'>
                    <button type="submit" form="formProject2Experience" class="btn btn-success"
			            href="../../../service/admin/edit_project2experience_bdd.php">Mise a jour</button>
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
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
		session_start();
		if($_SESSION ['admin'] != 1){
			header('Location: ' . '../../index.php');
			exit(var_dump($_SESSION['admin']));
		}
		include_once (__DIR__.'/../../dao/utilisateur_dao.php');
		include_once (__DIR__.'/../../dao/projet_dao.php');
		include_once (__DIR__.'/../../dao/refexperience_dao.php');
		include_once (__DIR__.'/../../dao/refpath_dao.php');
    ?>
  <title>Page Admin Projet</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/png" href="../../../img/logo/logo_MNHN.png" />

	<link rel="stylesheet" href="../../../css/bootstrap.min.css">
	<script src="../../../js/jquery-3.1.1.min.js"></script>
	<script src="../../../js/bootstrap.min.js"></script>

  <!-- edit projet -->
  <script>
    $(document).ready(function(){
      $('#edit-project').on('show.bs.modal', function (e) {
        var rowid = $(e.relatedTarget).data('id');
        $.ajax({
          type : 'post',
          url : './update/edit_project.php', //Here you will fetch records
          data :  'rowid='+ rowid, //Pass $id
          success : function(data){
            $('#fetched-data-project').html(data);//Show fetched data from database
          }
        });
      });
    });
  </script>
</head>
<body>
  <div class="container">
  <!-- Modals -->

    <!-- Edit projet -->
    <div class="modal fade" id="edit-project" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Editer projet</h4>
          </div>
          <div class="modal-body">
            <div class="fetched-data" id="fetched-data-project"></div>
          </div>
        </div>
      </div>
    </div>
    <!-- Fin edit projet -->

    <!-- Module projet -->
    <h2>Projets</h2>
    <p>
      <a href="./create/create_project.html" class="btn btn-success">Créer un projet</a>
    </p>
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>Nom</th>
          <th>Commentaire</th>
          <th>Actif</th>
          <th>Date creation</th>
        </tr>
      </thead>
      <tbody>
	      <?php
        foreach(ProjetDao::selectAll() as $row){
					echo '<form class="form" id="formProject2Experience'.$row['id_projet'].'" method="post" action="./update/edit_project2experience.php">';
        		echo '<input type="HIDDEN" name="idProject" value="'.$row['id_projet'].'">';
      	echo '</form>';
          echo '<tr>';
          echo '<td>'. $row['libelle_projet'] . '</td>';
          echo '<td>'. $row['commentaire_projet'] . '</td>';
          echo '<td>'. $row['actif_projet'] . '</td>';
          echo '<td>'. $row['datecreation_projet'] . '</td>';
          echo '<td>';
          echo '<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit-project" data-id="'.$row['id_projet'].'">Editer projet</a>';
					echo '</td><td>';
					echo '<button type="submit" form="formProject2Experience'.$row['id_projet'].'"" class="btn btn-info btn-sm" href="./update/edit_project2experience.php">Lier experiences</button>';
		      echo '</td>';
          echo '<tr>';
        }
	      ?>
      </tbody>
    </table>
    <!--Fin Module projet -->
		</br>
		</br>
		<div>
			<a class="btn btn-primary btn-sm" href="./">Utilisateurs</a>
			<a class="btn btn-primary btn-sm" href="./experience.php">Experiences</a>
		</div>
  </div>
</body>
</html>

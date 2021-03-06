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

		<header class="row">
			<div class="col-xs-12">
				<center>
					<h1>Page Admin Projet</h1>
				</center>
			</div>
			<div class="row">
				<div class="col-md-offset-3 col-md-6">
					<hr class="primary">
				</div>
			</div>

		<?php include (__DIR__.'/../../navbar.html')?>
		</header>
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
		<div>
			<a class="btn btn-primary btn-sm" href="./">Utilisateur</a>
			<a class="btn btn-primary btn-sm" disabled="disabled" href="./projet.php">Projets</a>
			<a class="btn btn-primary btn-sm" href="./experience.php">Expériences</a>
		</div>
    </br>
    </br>
    <p>
      <a href="./create/create_project.html" class="btn btn-success">Créer un projet</a>
    </p>
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>Nom</th>
          <th>Commentaire</th>
          <th>Actif</th>
          <th>Date création</th>
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
					echo '<button type="submit" form="formProject2Experience'.$row['id_projet'].'"" class="btn btn-info btn-sm" href="./update/edit_project2experience.php">Lier expériences</button>';
		      echo '</td>';
          echo '<tr>';
        }
	      ?>
      </tbody>
    </table>
    </br>
    </br>
    <!-- Module reccuperation log -->
    <form action="../../service/admin/download_log.php" method="post">
      <input class="btn btn-warning" type="submit" name="submit" value="Download Log" />
    </form>
  </div>
</body>
</html>

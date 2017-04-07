<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
		session_start();
		$_SESSION['admin'] = 1;
		if($_SESSION ['admin'] != 1){
			header('Location: ' . '../src/index.php');
			exit();
		}
		include_once (__DIR__.'/../src/dao/utilisateur_dao.php');
		include_once (__DIR__.'/../src/dao/projet_dao.php');
		include_once (__DIR__.'/../src/dao/refexperience_dao.php');
		include_once (__DIR__.'/../src/dao/reftypedonnee_dao.php');
		include_once (__DIR__.'/../src/dao/projet_utilisateur_dao.php');
    ?>
  <title>Page Admin</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/png" href="../img/logo/logo_MNHN.png" />

	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<script src="../js/jquery-3.1.1.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>


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

  <!-- active/desactive experience -->
  <script>
    $(document).ready(function(){
      $('#desactive-experience').on('show.bs.modal', function (e) {
        var rowid = $(e.relatedTarget).data('id');
        $.ajax({
          type : 'post',
          url : './update/delete_experience.php', //Here you will fetch records
          data :  'rowid='+ rowid, //Pass $id
          success : function(data){
            $('#fetched-data-experience').html(data);//Show fetched data from database
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

    <!-- Active/desactive experience -->
    <div class="modal fade" id="desactive-experience" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Désactivation utilisateur</h4>
          </div>
          <div class="modal-body">
            <div class="fetched-data" id="fetched-data-experience"></div>
          </div>
        </div>
      </div>
    </div>
    <!-- Fin active/desactive experience -->

    <!-- Fin Modals -->

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
						echo '<tr>';
						echo '<td>'. $row['libelle_projet'] . '</td>';
						echo '<td>'. $row['commentaire_projet'] . '</td>';
						echo '<td>'. $row['actif_projet'] . '</td>';
						echo '<td>'. $row['datecreation_projet'] . '</td>';
						if(1 == Projet2UtilisateurDAO::isJoin($row['id_projet'], $_SESSION['id_utilisateur']))
						{
							echo '<td>';
							echo '<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit-project" data-id="'.$row['id_projet'].'">Acceder au projet</a>';
							echo '</td>';
						}
						echo '<tr>';
        }
	      ?>
      </tbody>
    </table>
    <!--Fin Module projet -->

    <!-- Module ref experience -->
    <h2>Experiences</h2>
    <p>
      <a href="./create/create_experience.html" class="btn btn-success">Créer une experience</a>
    </p>
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>Libellé</th>
          <th>Commentaire</th>
          <th>Actif</th>
          <th>Date creation</th>
        </tr>
      </thead>
      <tbody>
	      <?php
        foreach(RefExperienceDao::selectAll() as $row){
          echo '<tr>';
          echo '<td>'. $row['libelle_refexperience'] . '</td>';
          echo '<td>'. $row['commentaire_refexperience'] . '</td>';
          echo '<td>'. $row['actif_refexperience'] . '</td>';
          echo '<td>'. $row['datecreation_refexperience'] . '</td>';
          echo '<td>';
          echo '<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#desactive-experience" data-id="'.$row['id_refexperience'].'">Activer/Desactiver experience</a>';
          echo '</td>';
          echo '</tr>';
        }
	      ?>
      </tbody>
    </table>
    <!--Fin Module ref experience -->

    <!-- Module type de donnée -->
    <h2>Types de donnée</h2>
    <p>
      <a href="./create/create_reftypedonnee.html" class="btn btn-success">Créer un type de donnée</a>
    </p>
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>Libellé</th>
          <th>Commentaire</th>
        </tr>
      </thead>
      <tbody>
	      <?php
        foreach(RefTypeDonneeDao::selectAll() as $row){
          echo '<tr>';
          echo '<td>'. $row['libelle_reftypedonnee'] . '</td>';
          echo '<td>'. $row['commentaire_reftypedonnee'] . '</td>';
          echo '<tr>';
        }
	      ?>
      </tbody>
    </table>
    <!--Fin Module type de donnée -->

    </br>
    </br>
    <!-- Module reccuperation log -->
    <form action="../src/service/admin/download_log.php" method="post">
      <input class="btn btn-warning" type="submit" name="submit" value="Download Log" />
    </form>
  </div>

	<form action="upload_manager.php" method="post" enctype="multipart/form-data">
	<h2>Upload File</h2>
	<label for="fileSelect">FileName:</label>
	<input type="file" name="fichier" id="fileSelect"><br>
	<input type="submit" name="submit" value="Upload">
	</form>
	<a href="download_manager.php">Clique ici pour télécharger</a>
</body>
</html>

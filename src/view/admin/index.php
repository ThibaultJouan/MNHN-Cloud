<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
		session_start();
		//if($_SESSION ['admin'] != 1){
		//	header('Location: ' . '../../index.php');
		//	exit(var_dump($_SESSION['admin']));
		//}
		include_once (__DIR__.'/../../dao/utilisateur_dao.php');
		include_once (__DIR__.'/../../dao/projet_dao.php');
		include_once (__DIR__.'/../../dao/refexperience_dao.php');
		include_once (__DIR__.'/../../dao/reftypedonnee_dao.php');
		include_once (__DIR__.'/../../dao/refpath_dao.php');
    ?>
  <title>Page Admin</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/png" href="../../../img/logo/logo_MNHN.png" />

	<link rel="stylesheet" href="../../../css/bootstrap.min.css">
	<script src="../../../js/jquery-3.1.1.min.js"></script>
	<script src="../../../js/bootstrap.min.js"></script>

  <!-- active/desactive user -->
  <script>
    $(document).ready(function(){
      $('#desactive-user').on('show.bs.modal', function (e) {
        var rowid = $(e.relatedTarget).data('id');
        $.ajax({
          type : 'post',
          url : './update/delete_user.php', //Here you will fetch records
          data :  'rowid='+ rowid, //Pass $id
          success : function(data){
            $('#fetched-data-user').html(data);//Show fetched data from database
          }
        });
      });
    });
  </script>

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

  <!-- edit pwd user-->
  <script>
    $(document).ready(function(){
      $('#edit-pwd-user').on('show.bs.modal', function (e) {
        var rowid = $(e.relatedTarget).data('id');
        $.ajax({
          type : 'post',
          url : './update/edit_pwd_user.php', //Here you will fetch records
          data :  'rowid='+ rowid, //Pass $id
          success : function(data){
            $('#fetched-data-pwd-user').html(data);//Show fetched data from database
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

  <!-- Active/desactive utilisateur -->
    <div class="modal fade" id="desactive-user" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Désactivation utilisateur</h4>
          </div>
          <div class="modal-body">
            <div class="fetched-data" id="fetched-data-user"></div>
          </div>
        </div>
      </div>
    </div>
    <!-- Fin active/desactive utilisateur -->

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

    <!-- Edit pwd user-->
    <div class="modal fade" id="edit-pwd-user" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Changer mot de passe utilisateur</h4>
          </div>
          <div class="modal-body">
            <div class="fetched-data" id="fetched-data-pwd-user"></div>
          </div>
        </div>
      </div>
    </div>
    <!-- Fin edit pwd user-->

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

    <!-- Module utilisateur -->
    <h2>Utilisateurs</h2>
    <p>
      <a href="./create/create_user.html" class="btn btn-success">Créé un utilisateur</a>
    </p>
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>Nom</th>
          <th>Prénom</th>
          <th>Addresse email</th>
          <th>Admin</th>
          <th>Actif</th>
          <th>Date creation</th>
        </tr>
      </thead>
      <tbody>
	      <?php
        foreach(UtilisateurDao::selectAll() as $row){
          echo '<tr>';
          echo '<td>'. $row['nom_utilisateur'] . '</td>';
          echo '<td>'. $row['prenom_utilisateur'] . '</td>';
          echo '<td>'. $row['mail_utilisateur'] . '</td>';
          echo '<td>'. $row['admin_utilisateur'] . '</td>';
          echo '<td>'. $row['actif_utilisateur'] . '</td>';
          echo '<td>'. $row['datecreation_utilisateur'] . '</td>';
          echo '<td>';
          echo '<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#desactive-user" data-id="'.$row['id_utilisateur'].'">Aviter/Desactiver utilisateur</a>';
          echo '<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit-pwd-user" data-id="'.$row['id_utilisateur'].'">Editer mot de passe utilisateur</a>';
          echo '</td>';
          echo '</tr>';
        }
	      ?>
      </tbody>
    </table>
    <!-- Fin Module utilisateur -->

    <!-- Module projet -->
    <h2>Projets</h2>
    <p>
      <a href="./create/create_project.html" class="btn btn-success">Créé un projet</a>
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
          echo '<td>';
          echo '<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit-project" data-id="'.$row['id_projet'].'">Editer projet</a>';
		      echo '</td>';
          echo '<tr>';
        }
	      ?>
      </tbody>
    </table>
    <!--Fin Module projet -->

    <!-- Module ref experience -->
    <h2>Experiences</h2>
    <p>
      <a href="./create/create_experience.html" class="btn btn-success">Créé une experience</a>
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
          echo '<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#desactive-experience" data-id="'.$row['id_refexperience'].'">Aviter/Desactiver experience</a>';
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
      <a href="./create/create_reftypedonnee.html" class="btn btn-success">Créé un type de donnée</a>
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

    <!-- Module path src -->
    <h2>Chemin du dossier contenant les projets :</h2>
		<div>
			<form class="form" id="formEditSrcPath" method="post" action="../../service/admin/edit_srcpath_bdd.php">
	  	<?php
				$src = RefPathDao::getSrcPath();
				echo '<input type="text" class="form-control" name="srcPath" value="'.$src['path_refpath'].'" form="formEditSrcPath"';
			?>
			</form>
		</div>
		<div class="row">
			<div class = 'col-md-12'>
				<button type="submit" form="formEditSrcPath" class="btn btn-success" href="../../service/admin/edit_srcpath_bdd.php">Mise a jour</button>
		</div>
		<!--Fin Module path src -->

    </br>
    </br>
    <!-- Module reccuperation log -->
    <form action="../../service/admin/download_log.php" method="post">
      <input class="btn btn-warning" type="submit" name="submit" value="Download Log" />
    </form>
  </div>
</body>
</html>

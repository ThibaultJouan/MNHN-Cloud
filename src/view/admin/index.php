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
  <title>Page Admin Utilisateur</title>
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

  <!-- edit user-->
  <script>
    $(document).ready(function(){
      $('#edit-pwd-user').on('show.bs.modal', function (e) {
        var rowid = $(e.relatedTarget).data('id');
        $.ajax({
          type : 'post',
          url : './update/edit_user.php', //Here you will fetch records
          data :  'rowid='+ rowid, //Pass $id
          success : function(data){
            $('#fetched-data-pwd-user').html(data);//Show fetched data from database
          }
        });
      });
    });
  </script>

  <script>
    $(document).ready(function(){
      $('#edit-pwd-user').on('show.bs.modal', function (e) {
        var rowid = $(e.relatedTarget).data('id');
        $.ajax({
          type : 'post',
          url : './update/edit_user.php', //Here you will fetch records
          data :  'rowid='+ rowid, //Pass $id
          success : function(data){
            $('#fetched-data-pwd-user').html(data);//Show fetched data from database
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

    <!-- Fin Modals -->

    <!-- Module utilisateur -->
    <h2>Utilisateurs</h2>
		<div>
			<a class="btn btn-primary btn-sm" disabled="disabled"  href="./">Utilisateur</a>
			<a class="btn btn-primary btn-sm" href="./projet.php">Projets</a>
			<a class="btn btn-primary btn-sm" href="./experience.php">Experiences</a>
		</div>
    </br>
    </br>
    <!-- Module reccuperation log -->
    <form action="../../service/admin/download_log.php" method="post">
      <input class="btn btn-warning" type="submit" name="submit" value="Download Log" />
    </form>
    </br>
    </br>
    <p>
      <a href="./create/create_user.html" class="btn btn-success">Créer un utilisateur</a>
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
					echo '</td><td>';
          echo '<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit-pwd-user" data-id="'.$row['id_utilisateur'].'">Editer utilisateur</a>';
					echo '</td><td>';
          echo '<a class="btn btn-info btn-sm" href="./update/edit_droit_user_project.php?idUser='.$row['id_utilisateur'].'">Editer droits utilisateur</a>';
          echo '</td>';
          echo '</tr>';
        }
	      ?>
      </tbody>
    </table>
    <!-- Fin Module utilisateur -->
  </div>
</body>
</html>

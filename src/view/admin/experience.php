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
  <title>Page Admin Experience</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/png" href="../../../img/logo/logo_MNHN.png" />

	<link rel="stylesheet" href="../../../css/bootstrap.min.css">
	<script src="../../../js/jquery-3.1.1.min.js"></script>
	<script src="../../../js/bootstrap.min.js"></script>

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

    <!-- Module ref experience -->
    <h2>Experiences</h2>
		<div>
			<a class="btn btn-primary btn-sm" href="./">Utilisateur</a>
			<a class="btn btn-primary btn-sm" href="./projet.php">Projets</a>
			<a class="btn btn-primary btn-sm" disabled="disabled" href="./experience.php">Experiences</a>
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
		</br>
		</br>
		<div>
			<a class="btn btn-primary btn-sm" href="./">Utilisateurs</a>
			<a class="btn btn-primary btn-sm" href="./projet.php">Projets</a>
			<a class="btn btn-primary btn-sm" disabled="disabled" href="./experience.php">Experience</a>
		</div>
  </div>
</body>
</html>

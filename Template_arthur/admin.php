<!DOCTYPE html>
<html lang="en">
<head>
    <?php
		  include_once ('utilisateur_dao.php');
    ?>
  <title>Page Admin</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script>
    $(document).ready(function(){
      $('#desactive').on('show.bs.modal', function (e) {
        var rowid = $(e.relatedTarget).data('id');
        $.ajax({
          type : 'post',
          url : 'delete_user.php', //Here you will fetch records 
          data :  'rowid='+ rowid, //Pass $id
          success : function(data){
            $('.fetched-data').html(data);//Show fetched data from database
          }
        });
      });
    });
  </script>
</head>
<body>

<div class="container">
  <!-- Modal -->
  <div class="modal fade" id="desactive" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Désactivation Utilisateur</h4>
        </div>
        <div class="modal-body">
          <div class="fetched-data"></div>
        </div>
      </div>
      
    </div>
  </div>
  <!-- Fin Modal -->  
  <h2>Utilisateurs</h2>
  <p>
    <a href="create.php" class="btn btn-success">Créé utilisateur</a>
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
        echo '<td>'. $row['datecreation_utilisateur'] . '<td>';
        echo '<td>';
        echo '<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#desactive" data-id="'.$row['id_utilisateur'].'">Aviter/Desactiver utilisateur</a>';
        echo '<td>';
        echo '<tr>';
      }
    ?>
    </tbody>
  </table>
</div>

</body>
</html>

<html>
  <head>
    <script src="../../../js/jquery-3.1.1.min.js"></script>
    <script>
    $("#active-usr").on('click',function(){
        var act = document.getElementById('active-usr');
        var rowid = act.getAttribute('data-id');
        $.ajax( {
            type : 'post',
            data : 'rowid='+ rowid,
            url  : '../../service/admin/switch_actif_user_bdd.php',
            success: function ( data ) {
                alert( data );
            },
            error: function ( xhr ) {
                alert( "error" );
            }
        });
    });
    </script>
  </head>
  <body>

<?php
session_start();
if($_SESSION ['admin'] != 1){
	header('Location: ' . '../../../index.php');
	exit();
}
include_once (__DIR__.'/../../../dao/utilisateur_dao.php');
if($_POST['rowid']) {
    $id = $_POST['rowid']; //escape string
    $row = UtilisateurDao::getNomPrenomActifById($id);
    ?>
    <div>
    Voulez-vous
    <?php
    if($row['actif_utilisateur'] == 1){
        echo "désactiver ";
     }
     else{
         echo "activer ";
     }
     echo $row['prenom_utilisateur']." ".$row['nom_utilisateur']."?";
     ?>
     </div>
     </br>
     </br>
     <div class = 'row'>
        <div class = 'col-md-3'>
            <p>
                <?php
                echo '<a href="index.php" class="btn btn-success" id="active-usr" data-id="'.$id.'">';

                    if($row['actif_utilisateur'] == 1){
                        echo "Désactive ";
                    }
                    else{
                        echo "Active ";
                    }
                    ?>
                </a>
            </p>
        </div>
        <div class = 'col-md-3'>
            <p>
                <a href="index.php" class="btn btn-warning">Annule</a>
            </p>
        </div>
     </div>
  </body>
</html>

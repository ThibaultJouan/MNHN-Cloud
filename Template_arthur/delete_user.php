<html>
  <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type = "text/javascript">
    $("#active").on('click',function(){
        var act = document.getElementById('active');
        var rowid = act.getAttribute('data-id');
        $.ajax( {
            type : 'post',
            data : 'rowid='+ rowid,
            url  : 'switch_actif_bdd.php',
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
include_once (__DIR__.'/dao/utilisateur_dao.php');
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
     <div class = 'row'>
        <div class = 'col-md-3'>
            <p>
                <?php
                echo '<a href="admin.php" class="btn btn-success" id="active" data-id="'.$id.'">';

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
                <a href="admin.php" class="btn btn-warning">Annule</a>
            </p>
        </div>  
     </div>
     <?php
     }  
    ?>
  </body>
</html>
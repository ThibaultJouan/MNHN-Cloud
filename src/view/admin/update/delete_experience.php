<html>
  <head>
    <script src="../../../js/jquery-3.1.1.min.js"></script>
    <script>
    $("#active-exp").on('click',function(){
        var act = document.getElementById('active-exp');
        var rowid = act.getAttribute('data-id');
        $.ajax( {
            type : 'post',
            data : 'rowid='+ rowid,
            url  : '../../service/admin/switch_actif_experience_bdd.php',
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
include_once (__DIR__.'/../../../dao/refexperience_dao.php');
if($_POST['rowid']) {
    $id = $_POST['rowid']; //escape string
    $row = RefExperienceDao::getLibelleActifById($id);
    ?>
    <div>
    Voulez-vous
    <?php
    if($row['actif_refexperience'] == 1){
        echo "désactiver ";
     }
     else{
         echo "activer ";
     }
     echo $row['libelle_refexperience']."?";
     ?>
     </div>
     </br>
     </br>
     <div class = 'row'>
        <div class = 'col-md-3'>
            <p>
                <?php
                echo '<a href="experience.php" class="btn btn-success" id="active-exp" data-id="'.$id.'">';

                    if($row['actif_refexperience'] == 1){
                        echo "Désactiver ";
                    }
                    else{
                        echo "Activer ";
                    }
                    ?>
                </a>
            </p>
        </div>
        <div class = 'col-md-3'>
            <p>
                <a href="experience.php" class="btn btn-warning">Annuler</a>
            </p>
        </div>
     </div>
     <?php
     }
    ?>
  </body>
</html>

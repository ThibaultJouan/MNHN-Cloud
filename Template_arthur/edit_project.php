<html>
  <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  </head>
  <body>
    <?php
      include_once (__DIR__.'/dao/projet_dao.php');
      if($_POST['rowid']) {
        $id = $_POST['rowid'];
        $row = ProjetDao::getLibelleCommentaireActifById($id);  
    ?>
    <div class="container">
      <div class="call-to-action">
		    <div class="service-box">
          <form class="form" id="formProject2User" method="post" action="edit_project2user.php">
            <?php
              echo '<input type="HIDDEN" name="idProject" value="'.$id.'">';
            ?>
          </form>
          <form class="form" id="formProject2Experience" method="post" action="edit_project2experience.php">
            <?php
              echo '<input type="HIDDEN" name="idProject" value="'.$id.'">';
            ?>
          </form>
			    <form class="form" id="formProject" method="post" action="edit_project_bdd.php">
            <?php
              echo '<input type="HIDDEN" name="idProject" value="'.$id.'">';
            ?>
						  <p class="text-muted">Nom</p>
              <div class="row">
                <div class="col-md-5">
                  <?php
						        echo '<input type="text" class="form-control" name="libelleProject" value = "'.$row['libelle_projet'].'" form="formProject">';
                  ?>
                </div>
              </div>
						  <p class="text-muted">Commentaire </p>
              <div class="row">
                <div class="col-md-5">
                  <?php
                    echo '<textarea class="form-control"  name="commentProject" rows="5" form="formProject">'.$row['commentaire_projet'].'</textarea>';
                  ?>
                </div>
              </div>
              <?php
              if($row['actif_projet'] == 0){
                echo '<label><input type="checkbox" name="actifProject" value="yes" form="formProject">Actif</label>';
              }
              else{
                echo '<label><input type="checkbox" name="actifProject" value="yes" checked>Actif</label>';
              }          
              ?>
				  </form>
			  </div>
      </div>
      <br/>
      <br/>
      <div class="row">
        <div class = 'col-md-2'>
          <button type="submit" form="formProject" class="btn btn-success"
			      href="edit_project_bdd.php">Mise a jour</button>
        </div>
        <div class = 'col-md-2'>
          <button type="submit" form="formProject2User" class="btn btn-success"
			      href="edit_project2user.php">Ajouter utilisateurs</button>
        </div>
        <div class = 'col-md-2'>
          <button type="submit" form="formProject2Experience" class="btn btn-success"
			      href="edit_project2experience.php">Ajouter experiences</button>
        </div>
        <div class = 'col-md-2'>
          <p>
            <a href="admin.php" class="btn btn-warning">Annule</a>
          </p>
        </div>  
      </div>
    </div>
    <?php
    } 
    ?>
  </body>
</html>
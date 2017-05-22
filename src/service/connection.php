<?php
include_once (__DIR__.'/../dao/utilisateur_dao.php');
if($_POST['emailConn'] && $_POST['mdpConn']) {
	$email = $_POST['emailConn'];
	$mdp = $_POST['mdpConn'];

	$data = UtilisateurDao::getIdNomPrenomActifAdminByMailMotdepasse($email,$mdp);
	if (isset($data['actif_utilisateur']) &&  $data['actif_utilisateur'] == 1){
		session_start ();
		$_SESSION['prenom'] = $data['prenom_utilisateur'];
		$_SESSION['nom'] = $data['nom_utilisateur'];
		$_SESSION['admin'] = $data['admin_utilisateur'];
		$_SESSION['id_utilisateur'] = $data['id_utilisateur'];
		header('location:./../');
	}
	if (isset($data['actif_utilisateur']) &&  $data['actif_utilisateur'] == 0){
		header('location:./../view/connection/validate/connection_user_inactif.html');
	}
	if (!isset($data['actif_utilisateur'])){
		header('location:./../view/connection/validate/Connection_erreur.html');
	}
}else{
	header('location:./../');
}
?>

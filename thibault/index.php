<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>File Test Upload</Title>
</head>
<body>
	<form action="upload_manager.php" method="post" enctype="multipart/form-data">
	<h2>Upload File</h2>
	<label for="fileSelect">FileName:</label>
	<input type="file" name="fichier" id="fileSelect"><br>
	<input type="submit" name="submit" value="Upload">
	</form>
	<a href="download_manager.php">Clique ici pour telecharger</a>
</body>
</html>

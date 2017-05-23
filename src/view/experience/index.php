<?php
include_once(__DIR__.'/../../service/configPath.php');
include_once(__DIR__.'/../../dao/projet_dao.php');
include_once(__DIR__.'/../../dao/refexperience_dao.php');

$path = PATH_PROJET;

$id_projet = $_GET['projet'];
$id_exp = $_GET['exp'];
$section = $_GET['section'];

$row = ProjetDao::getLibelleById($id_projet);
$pathProjet = $path.$row['libelle_projet'];
$row = RefExperienceDao::getLibelleActifById($id_exp);
$pathExperience = $pathProjet.'/'.$row['libelle_refexperience'];
$directory = openDir($pathExperience.'/'.$section);

while($entryName = readdir($directory)) {
	$dirArray[] = $entryName;
}

closedir($directory);

$indexCount	= count($dirArray);
Print ("$indexCount files<br>\n");
print("<TABLE border=1 cellpadding=5 cellspacing=0 class=whitelinks>\n");
print("<TR><TH>Filename</TH><th>Filetype</th><th>Filesize</th></TR>\n");
// loop through the array of files and print them all
for($index=0; $index < $indexCount; $index++) {
	if (substr("$dirArray[$index]", 0, 1) != "."){ // don't list hidden files
		print("<TR><TD><a href=\"./../../../../MNHN-Cloud/src/service/uploadManager.php?projet=$id_projet&exp=$id_exp&section=$section&fileName=$dirArray[$index]\">$dirArray[$index]</a></td>");
		print("<td>");
		print(filetype($dirArray[$index]));
		print("</td>");
		print("<td>");
		print(filesize($dirArray[$index]));
		print("</td>");
		print("</TR>\n");
	}
}
print("</TABLE>\n");

?>

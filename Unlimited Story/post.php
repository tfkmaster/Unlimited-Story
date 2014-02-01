<?php 
header('Content-type: text/html; charset=UTF-8'); 
$episode = $_GET['episode'];
if ((!is_numeric($episode)) || ($episode<1)) {
	exit("Format [episode] non valide");
}

$fepisode="p1/".htmlentities($episode).".html";
$fb=fopen ("dernier.txt", "r");
$editableposts=fread ($fb, filesize("dernier.txt"));
fclose($fb);

if ($episode>$editableposts) {
echo "Ce post ne peut être créer car aucun post ne lui est lié.<br><br>";
echo "<a href=\"post.php?episode=1\">* Aller au début de l'histoire.</A>";
echo "<br><br><a href=\"javascript:history.go(-1)\">* Retourner en arrière.</p></a>";
} elseif (file_exists($fepisode)) {
header("Location: p1/".htmlentities($episode).".html")    ;
} else {
echo "Post n°".htmlentities($episode)." :"; 
//Le fichier n'existe pas
echo " :<br><br>Il n'y a aucun post à cet endroit. N'hésitez pas à en créer un !<br><br>";
echo "<a href=\"ajout.php?episode=".htmlentities($episode)."\">* Créer le post.</A>";
echo "<br><br><a href=\"javascript:history.go(-1)\">* Ne pas faire de post et retourner en arrière.</p></a>";
}
?>
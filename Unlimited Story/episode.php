<?php 
header('Content-type: text/html; charset=UTF-8'); 
$episode = $_GET['episode'];

$fepisode=$episode.".htm";
if (file_exists($fepisode)) {
header("Location: ".$episode.".htm")    ;
} else {
echo "EPISODE ".$episode." :"; 
    //Le fichier n'existe pas
	echo " :<br><br>Cet episode n'existe pas encore. N'h&eacute;sitez pas &agrave; le cr&eacute;er !<br><br>";
	echo "<a href=\"ajout.php?episode=".$episode."\">Cr&eacute;er l'&eacute;pisode.</A>";
echo "<br><br><a href=\"javascript:history.go(-1)\">(Retour) Ne <b>pas</b> cr&eacute;er l'&eacute;pisode.</p></a>";
}
?>
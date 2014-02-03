<?php header('Content-type: text/html; charset=UTF-8'); ?>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>100 derniers posts</title>
<link href="indexstyle.css" rel="stylesheet" type="text/css">
</head>
<a href="all.php">Voir tous les posts</a>
<br><br>
Les 100 derniers ajouts :<br>
<?
$filetotal="";
$fd=fopen("arbre.txt","r");
while (!feof ($fd)) {
$buffer = fgets($fd);
$filetotal= $filetotal . $buffer;
}
//met chaque ligne( >43=2;50;53;) dans le tableau coup
$tabcoup=explode(">",$filetotal);
//trouve la taille du tableau
$taille=count($tabcoup);
?>
<?


for ($i=100; $i!=0; $i--)
{
//isole le n° de l'épisode
$nepisode=explode("=",$tabcoup[$taille-$i]);
echo "<br><a href=p1/".$nepisode[0].".html>Post ". $nepisode[0];
//isole le titre de l'épisode
$nepisode=explode("{",$tabcoup[$taille-$i]);
//vérifie s'il y a titre
if(empty($nepisode[1])) 
{}
else{
// Test si la longueur du texte dépasse la limite
	if (strlen($nepisode[1])>40){
	$nepisode[1] = substr($nepisode[1], 0, 40);
	$nepisode[1]=$nepisode[1]."...";
	}

$nepisode=explode("}",$nepisode[1]);
echo " : ". $nepisode[0];
}
echo "</a>";
//isole le nom de l'auteur
$nepisode=explode("[",$tabcoup[$taille-$i]);
//vérifie s'il y a un nom d'auteur
if(empty($nepisode[1])) 
{}
else{
$nepisode=explode("]",$nepisode[1]);
echo  "<i> par ".$nepisode[0]."</i>";
}
}
?>
<?php header('Content-type: text/html; charset=UTF-8'); ?>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Tout les posts</title>
<link href="indexstyle.css" rel="stylesheet" type="text/css">
</head>
Tous les Posts
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

echo " (".$taille.") :";
for ($i=$taille; $i!=0; $i--)
{
//isole le n? de l'?isode
$nepisode=explode("=",$tabcoup[$taille-$i]);
echo "<br><a href=".$nepisode[0].".htm>Post n°". $nepisode[0];
//isole le titre de l'?isode
$nepisode=explode("{",$tabcoup[$taille-$i]);
//v?ifie s'il y a titre
if(empty($nepisode[1])) 
{}
else{
// Test si la longueur du texte d?asse la limite
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
//v?ifie s'il y a un nom d'auteur
if(empty($nepisode[1])) 
{}
else{
$nepisode=explode("]",$nepisode[1]);
echo  "<i> par ".$nepisode[0]."</i>";
}
}
?>
<?php header('Content-type: text/html; charset=UTF-8'); ?>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Recherche Auteur</title>
<link href="indexstyle.css" rel="stylesheet" type="text/css">
</head><p align=right>Post parent : <a href="index.php">index</a><center>
<?php
//on ouvre tout le fichier
$filetotal="";
$auteur = $_GET['auteur'];
$lecture=fopen("arbre.txt","r");
$auteur=stripslashes($auteur);
$auteur = htmlspecialchars($auteur, ENT_QUOTES);
$tentativepirate=false;
$auteurtrouve=false; 

if(strpos($auteur,"&lt;")!==false){$tentativepirate=true;}

if(strpos($auteur,"&gt;")!==false){$tentativepirate=true;}

if(strpos($auteur,"echo")!==false){$tentativepirate=true;}

if($tentativepirate==true)
{
echo "Votre tentative de piratage à été détecté !... Non je déconne :P";
}

echo "Recherche de l'auteur : ".$auteur."<br>";
//lit ligne par ligne tant qu'on est pas ?la fin
while (!feof ($lecture)) {
$ligne= fgets($lecture, 1024);
//on trouve la ligne par l'auteur
if (preg_match("[".$auteur."]", $ligne)){
$auteurtrouve=true; 
//echo "<br>".$ligne;

//on trouve le n?
$coup=split("=", $ligne);
$coup=split(">", $coup[0]);
echo "<br><a href=p1/".$coup[1].".html>Post n°".$coup[1]."</a>";

//isole le titre de l'?isode
$nepisode=explode("{",$ligne);
//v?ifie s'il y a titre
if(empty($nepisode[1])) 
{}
else{
// Test si la longueur du texte d?asse la limite
	if (strlen($nepisode[1])>200){
	$nepisode[1] = substr($nepisode[1], 0, 40);
	$nepisode[1]=$nepisode[1]."...";
	}

$nepisode=explode("}",$nepisode[1]);
echo " : ". $nepisode[0];
}
}
}

if($auteurtrouve==false)
{
echo "Cet auteur est introuvable.";
}
<?php header('Content-type: text/html; charset=UTF-8'); ?>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Infinie Aventure</title>
<link href="indexstyle.css" rel="stylesheet" type="text/css">
</head><p align=right>Episode parent : <a href="index.php">index</a>
<center><H6>L'histoire du retour des loutres-loups-garoutes-g&eacute;antes du futur du 6e orbe de Johnson dans les bars chinois, les tunnels souterrains et tout Tamriel, autrement dit l'...</H6>
<H1>INFINIE AVENTURE</H1></center>

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
echo "Votre tentative de piratage a &eacute;t&eacute; signal&eacute;e. Non je d&eacute;conne.<br><br>Alors on disait...";
}

echo "Recherche de l'auteur : ".$auteur."<br>";
//lit ligne par ligne tant qu'on est pas à la fin
while (!feof ($lecture)) {
$ligne= fgets($lecture, 1024);
//on trouve la ligne par l'auteur
if (preg_match("[".$auteur."]", $ligne)){
$auteurtrouve=true; 
//echo "<br>".$ligne;

//on trouve le n°
$coup=split("=", $ligne);
$coup=split(">", $coup[0]);
echo "<br><a href=\"".$coup[1].".htm\">Episode ".$coup[1]."</a>";

//isole le titre de l'épisode
$nepisode=explode("{",$ligne);
//vérifie s'il y a titre
if(empty($nepisode[1])) 
{}
else{
// Test si la longueur du texte dépasse la limite
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
echo "Cet auteur est introuvable sur l'Infinie Aventure.";
}

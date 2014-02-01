<?php header('Content-type: text/html; charset=UTF-8'); ?>
<html>
<head><title>Hack-Free Story</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="indexstyle.css" rel="stylesheet" type="text/css">
</head>
<body>
<center>
<H1>Hack-Free Story</H1>
<h2>L'incroyable histoire des membres d'Hack-Free commence ici et maintenant!</h2></center>

<div class="aventure1"><b>Le livre des joueurs :</b><br>
<a href="post.php?episode=1">Commencer l'histoire depuis le début.</a><br><br>

Les 10 derniers Posts :
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


for ($i=10; $i!=0; $i--)
{
//isole le n° de l'épisode
$nepisode=explode("=",$tabcoup[$taille-$i]);
echo "<br><a href=p1/".$nepisode[0].".html>Post n°". $nepisode[0];
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
<br><br><a href="last100.php">Les 100 derniers Posts</a><br><br>
<a href="arbre.txt">Le plan de l'histoire au format texte</a>
</div>
<div class="createurs">
<b>La table des auteurs :</b>
<br><a href="FAQ.php">FAQ</a><br>
<br>
<b><u>Les meilleurs auteurs :</b></u>
<?
$tabauteurclassement[0]="";
$tabnumclassement[0]=0;
$tabauteurclassement[1]="";
$tabnumclassement[1]=0;
//pour tout le tableau, on cherche un nom d'auteur
for ($i=1; $i!=$taille;  $i++)
{
//echo "<br>teste ".$tabcoup[$i];
	//si il y a un [, ca veut dire qu'on a un auteur, on coupe (à précéder de \ pcq car spécial)
	if (preg_match("/\[/",$tabcoup[$i])){
	$auteur=preg_split("/\[/",$tabcoup[$i]);
	$auteur=preg_split("/\]/",$auteur[1]);
	$auteur[1]=$auteur[0];
	//echo "<br>AUTEUR ".$auteur[1];
	
		//on rajoute l'auteur à une liste s'il n'y est pas
		if (!preg_match("/".$auteur[1]."/",$listeauteur)){
		//echo "<br>ON AJOUTE AUTEUR ".$auteur[1];
		$listeauteur=$listeauteur.$auteur[1];
		//on le rajoute dans le tableau auteur
		$tabauteur[]=$auteur[1];
		}
	
	}

}

//On liste la liste auteur
//echo "Liste auteur=".$listeauteur;
//echo "taille tabauteur=".count($tabauteur);

//une fois la liste faite, on regarde combien de fois apparait chaque auteur dans l'arbre

//pour 1 fois
for ($j=0; $j!=5;  $j++){
//pour chaque auteur
	for ($i=0; $i<count($tabauteur); $i++){
	//on compte le nombre d'occurence dans l'arbre
	//echo "nom : ".$tabauteur[$i]." Occurence : ".substr_count($filetotal,$tabauteur[$i])."<br>";

	//Si le nombre d'occurence est superieur à celui de l'auteur d'avant, on le remplace
		if (substr_count($filetotal,$tabauteur[$i])>$tabnumclassement[$j]){
		//seulement si l'auteur n'est pas déjà sur le podium
			if(!preg_match("/".$tabauteur[$i]."/",$podium)){
			$tabauteurclassement[$j]=$tabauteur[$i];
			$tabnumclassement[$j]=substr_count($filetotal,"[".$tabauteur[$i]."]");}
		}		
	}
	
//une fois qu'on a parcouru les auteurs, on met l'auteur avec le plus d'occurences sur le podium
$podium=$podium.$tabauteurclassement[$j].$tabnumclassement[$j];
//echo "podium ".$podium;
echo "<br><br><b>".($j+1).".</b> <a href=\"rechercheparauteur.php?auteur=".$tabauteurclassement[$j]."\">".$tabauteurclassement[$j]."<a><br>"."(".$tabnumclassement[$j]." Posts)";
}
?>
<br><br>Merci à tous ceux qui participent à cette grande histoire :) !<br>
</div>
<br>
<br>
</body>
</html>
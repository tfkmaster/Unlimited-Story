<?php
header('Content-type: text/html; charset=UTF-8'); 
$etatepisode="";
$episode = $_GET['episode'];
if ((!is_numeric($episode)) || ($episode<1)) {
	exit("Format [episode] non valide");
}

if(empty($_POST['retour'])) 
{
$retour="";
}
else{
$retour = $_POST['retour'];
}
if(empty($_POST['description'])) 
{
$description="";
}
else{
$description = $_POST['description'];
$description=stripslashes($description);
}
if(empty($_POST['titre'])) 
{
$titre="";
}
else{
$titre = $_POST['titre'];
$titre=stripslashes($titre);
}
if(empty($_POST['choix'])) 
{
$choix="";
}
else{
$choix = $_POST['choix'];
}
$fp = fopen ("last.txt", "r");
$n_dernier = fread ($fp, filesize("last.txt"));
fclose ($fp);

$fepisode="p1/".htmlentities($episode).".html";
if ($episode>$n_dernier){
	$etatepisode="outofrange";
	$retour="true";
}

if ($retour!="true"){
if (file_exists($fepisode)) {
    //L'?isode existe d??!
	$etatepisode="Ce post existe déjà.";
	echo "Ce post existe déjà !";
} else {
$file="create".htmlentities($episode).".html";
if (file_exists($file)) {
    //L'?isode est en cours de cr?tion !
	$date_fic=filemtime($file);
	//echo "heureafichier".$date_fic;
	//on calcule l'heure de la creation du fichier et on la compare à l'heure actuelle'
	//$date_fic=date("d/m/Y h:i:s", filemtime($file));
	
	$heureactuelle=time();
	//echo "heureactuelle".$heureactuelle;
	$heureactuelle=$heureactuelle-$date_fic;
	//echo "difference".$heureactuelle;
	if ($heureactuelle>900 or $heureactuelle<2){
	//si le fichier ?plus de deux heure (7200) secondes, on le d?ruit et le recr? avec notre heure.
	$file="create".htmlentities($episode).".html";
    unlink($file); 
	$fp = fopen ($file, "w");
    fclose ($fp);
	}
	else{
	$etatepisode="encours";
	echo "<br>Ce post est déjà en cours d'écriture, si l'auteur à abandonner son écris, n'hésitez pas à réessayer plus tard (les auteurs ont 15 minutes pour faire leur post).";
	echo "<br><br><a href=\"javascript:history.go(-1)\">Retour en arrière</p></a>";
} 
}
else {
// s'il n'existe pas
$fp2 = fopen ($file, "w");
fclose ($fp2);
}
}
}

if($etatepisode=="outofrange") {
echo "Ce post ne peut être créer car aucun post ne lui est lié.<br><br>";
echo "<a href=\"post.php?episode=1\">* Aller au début de l'histoire.</A>";
echo "<br><br><a href=\"javascript:history.go(-1)\">* Retourner en arrière.</p></a>";
}
else if($etatepisode!="encours")
{
echo "<br></b><b>Post n°";
echo htmlentities($episode)." :"; 
echo "<form method=\"POST\" action=\"addfinal.php?episode=".htmlentities($episode)."\">";
echo "</b> Vous pouvez donner un titre à votre Post (conseillé)<br> <INPUT NAME=\"titre\" size=70% value=\"".$titre."\">
<br>
<br>
Contenu du Post :
<br>
<textarea name=\"description\" rows=10 cols=80 >".$etatepisode.$description."</textarea>
<br>
Tags de mise en forme :
[b]<b>gras</b>[/b] | [i]<i>italique</i>[/i] | [u]<u>souligné</u>[/u] | [s]<s>barré</s>[/s] | [img]URL de l'image[/img]
<br>
<br>
Nombre de choix du joueur ";
echo "<INPUT NAME=\"choix\" size=10% value=\"".$choix."\">
<br>
<br>
<input type=submit value=\"Accepter\"> - Continuer la création du post.
<br>
(Merci d'écrire le plus correctement possible).
<hr>
</form>
<a href=\"javascript:history.go(-1)\">Retour en arriere.</a>
<br>";
} 
?>
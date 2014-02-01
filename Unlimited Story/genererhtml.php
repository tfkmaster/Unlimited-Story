<?php 
header('Content-type: text/html; charset=UTF-8'); 
$episode = $_GET['episode'];
if ((!is_numeric($episode)) || ($episode<1)) {
	exit("Format [episode] non valide");
}
$fb=fopen ("dernier.txt", "r");
$editableposts=fread ($fb, filesize("dernier.txt"));
fclose($fb);

$fepisode="p1/".htmlentities($episode).".html";
if (file_exists($fepisode)) {
echo "Ce post existe déjà !";}
else
{
if ($episode>$editableposts) {
echo "Ce post ne peut être créer car aucun post ne lui est lié.<br><br>";
echo "<a href=\"post.php?episode=1\">* Aller au début de l'histoire.</A>";
echo "<br><br><a href=\"javascript:history.go(-1)\">* Retourner en arrière.</p></a>";
} else {
if(empty($_POST["description"]) && empty($_POST["titre"]))
{
echo "Pas de contenu, ni de titre !";
}
else
{
//on recupere les infos
$style= $_POST["style"];
$titre= $_POST["titre"];
$description= $_POST["description"];
$chparentarbretotal="";

$titre=stripslashes($titre);
$titre = htmlspecialchars($titre, ENT_QUOTES);
$description=stripslashes($description);
$description = htmlspecialchars($description, ENT_QUOTES);
$description=str_replace ("[br]", "<br>", $description);
$description=str_replace ("[b]", "<b>", $description);
$description=str_replace ("[/b]", "</b>", $description);
$description=str_replace ("[B]", "<b>", $description);
$description=str_replace ("[/B]", "</b>", $description);
$description=str_replace ("[i]", "<i>", $description);
$description=str_replace ("[/i]", "</i>", $description);
$description=str_replace ("[I]", "<i>", $description);
$description=str_replace ("[/I]", "</i>", $description);
$description=str_replace ("[u]", "<u>", $description);
$description=str_replace ("[/u]", "</u>", $description);
$description=str_replace ("[U]", "<u>", $description);
$description=str_replace ("[/U]", "<u>", $description);
$description=str_replace ("[s]", "<s>", $description);
$description=str_replace ("[/s]", "</s>", $description);
$description=str_replace ("[img]", "<img src=\"", $description);
$description=str_replace ("[/img]", "\">", $description);
$description=str_replace ("\r", "<br>",$description);
$file="p1/".htmlentities($episode).".html";
$fp = fopen ($file, "w");
$fb = fopen ("dernier.txt", "r+");
$arbre = fopen ("arbre.txt", "a+");
fputs ($arbre,"\r\n>".htmlentities($episode)."=");
$lastnbr=fread ($fb, filesize("dernier.txt"));
//on cherche l'épisode parent
$chparentarbre = fopen ("arbre.txt", "r");

while (!feof ($chparentarbre )) {
$buffer = fgets($chparentarbre , 4096);
$chparentarbretotal= $chparentarbretotal . $buffer;
}
//on chope l'?isode m?e
$epmere=split(htmlentities($episode).";",$chparentarbretotal);
//echo "episode mere0 :".$epmere[0]."<br>";
$epmere=split(">",$epmere[0]);
//$taillepemere=ubound($epmere);
//echo "episode mere :".$epmere[sizeof($epmere)-1];
$epmere=split("=",$epmere[sizeof($epmere)-1]);
//echo "<bR>episode mere :".$epmere[0];
//fin du cherchage
fputs ($fp,"<head><meta http-equiv=\"Content-type\" content=\"text/html; charset=UTF-8\"/><title>Post ".htmlentities($episode)." - ".$titre."</title><link href=\"nostyle.css\" rel=\"stylesheet\" type=\"text/css\"></head><p align=right>Post parent : <a href=\"".$epmere[0].".htm\">".$epmere[0]."</a></p><div class=\"general\"><div class=\"titre\"><H1>".$titre."</H1></div><div class=\"episode\"><H2>Post ".htmlentities($episode)." :</H2></div><div class=\"description\">".$description."<br><br></div><div class=\"liens\">");
$nbrchoix=$_POST["nbrchoix"];
for ($i=0; $i!=$nbrchoix; $i++)
{
$choix=$_POST["choix".$i];
$linkchoix=$_POST["linkchoix".$i];
if ( is_numeric($linkchoix) ){
$choix = htmlspecialchars($choix, ENT_QUOTES);
$choix=stripslashes($choix) ;
}
else{
$linkchoix="";
$choix = htmlspecialchars($choix, ENT_QUOTES);}
$choix=stripslashes($choix) ;
if(empty($choix)){}
else{
if(empty($linkchoix)){
$lastnbr++;
fputs ($arbre,$lastnbr.";");
fputs ($fp,"<a href=\"../post.php?episode=".$lastnbr."\">".$choix."</a><br>");}
else{
if($linkchoix==$lastnbr){
fputs ($arbre,$linkchoix.";");
fputs ($fp,"<a href=\"../post.php?episode=".$linkchoix."\">".$choix."</a><br>");}

if($linkchoix>$lastnbr){
$lastnbr++;
fputs ($arbre,$lastnbr.";");
fputs ($fp,"<a href=\"../post.php?episode=".$lastnbr."\">".$choix."</a><br>");}
if($linkchoix<$lastnbr){
fputs ($arbre,$linkchoix.";");
fputs ($fp,"<a href=\"../post.php?episode=".$linkchoix."\">".$choix."</a><br>");}
}
fseek($fb,0); 
fputs ($fb,$lastnbr);
}
}
if(empty($_POST["auteur"]))
{
fputs ($fp,"</div></div>");
}
else{
$auteur=$_POST["auteur"];
$auteur=stripslashes($auteur);
$auteur = htmlspecialchars($auteur, ENT_QUOTES);
fputs ($fp,"</div></div><br><br><hr><b><i>".$auteur);
$auteur=str_replace ("[", "", $auteur);
$auteur=str_replace ("]", "", $auteur);
$auteur=str_replace ("{", "", $auteur);
$auteur=str_replace ("}", "", $auteur);
fputs ($arbre,"[".$auteur."]");
}
if(empty($_POST["titre"]))
{
}
else{
$auteur=str_replace ("[", "", $auteur);
$auteur=str_replace ("]", "", $auteur);
$auteur=str_replace ("{", "", $auteur);
$auteur=str_replace ("}", "", $auteur);
fputs ($arbre,"{".$titre."}");
}
fclose ($fp);
fclose ($fb);
fclose ($arbre);
$file="create".htmlentities($episode).".html";
unlink($file); 
Echo "Votre post a bien été ajouté !<br><br><a href=\"post.php?episode=".htmlentities($episode)."\">Voir le post.</a>";
}
}
}
?>
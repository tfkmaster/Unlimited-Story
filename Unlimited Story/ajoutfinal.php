<?php 
header('Content-type: text/html; charset=UTF-8'); 
$episode = $_GET['episode'];
if ((!is_numeric($episode)) || ($episode<1)) {
	exit("Format [episode] non valide");
}
$fb = fopen ("dernier.txt", "r");
$lastnbr=fread ($fb, filesize("dernier.txt"));
fclose ($fb);

//test des variables
$nbrchoix= $_POST["choix"];
if(empty($_POST["description"])) 
{
$description="";
echo "<H1>Vous n'avez mis aucun contenu !</h1>";
echo "<br><br><br><a href=\"javascript:history.go(-1)\">Retour en arriere.</A><br>";
} 
else {
if ($episode>$lastnbr) {
echo "Ce post ne peut être créer car aucun post ne lui est lié.<br><br>";
echo "<a href=\"post.php?episode=1\">* Aller au début de l'histoire.</A>";
echo "<br><br><a href=\"javascript:history.go(-1)\">* Retourner en arrière.</p></a>";
} else {
$description= $_POST["description"] ;
if(empty($_POST["titre"])) 
{
$titre="";
} 
else {
$titre= $_POST["titre"] ;
//$titre=str_replace ("<", "&#8249;", $titre);
//$titre=str_replace (">", "&#8250;", $titre);
//$titre=str_replace ("\"", "&quot;", $titre);
}

$fepisode="p1/".htmlentities($episode).".html";
if (file_exists($fepisode)) {
    //L'?isode existe d??!
    echo "<br><H1>Le post ".htmlentities($episode)." existe déjà !</H1>";

} else {
//si l'?isode n'existe pas'
$apercudescription=$description;
$titre = htmlspecialchars($titre, ENT_QUOTES);
$titre=stripslashes($titre);
$apercudescription=stripslashes($apercudescription);
$description=str_replace ("\"", "&quot;", $description);
$description=stripslashes($description);
$apercudescription = htmlspecialchars($apercudescription, ENT_QUOTES);
$apercudescription=str_replace ("[br]", "<br>", $apercudescription);
$apercudescription=str_replace ("[b]", "<b>", $apercudescription);
$apercudescription=str_replace ("[/b]", "</b>", $apercudescription);
$apercudescription=str_replace ("[B]", "<b>", $apercudescription);
$apercudescription=str_replace ("[/B]", "</b>", $apercudescription);
$apercudescription=str_replace ("[i]", "<i>", $apercudescription);
$apercudescription=str_replace ("[/i]", "</i>", $apercudescription);
$apercudescription=str_replace ("[I]", "<i>", $apercudescription);
$apercudescription=str_replace ("[/I]", "</i>", $apercudescription);
$apercudescription=str_replace ("[u]", "<u>", $apercudescription);
$apercudescription=str_replace ("[/u]", "</u>", $apercudescription);
$apercudescription=str_replace ("[U]", "<u>", $apercudescription);
$apercudescription=str_replace ("[/U]", "<u>", $apercudescription);
$apercudescription=str_replace ("[s]", "<s>", $apercudescription);
$apercudescription=str_replace ("[/s]", "</s>", $apercudescription);
$apercudescription=str_replace ("[img]", "<img src=\"", $apercudescription);
$apercudescription=str_replace ("[/img]", "\">", $apercudescription);

$apercudescription=str_replace ("\r", "<br>",$apercudescription);
echo "Votre post sera comme ceci :<hr><H1>".$titre."</H1>";
echo "<H2>Post ".htmlentities($episode)." :</h2>"; 
echo $apercudescription;
echo "<form method=\"POST\" action=\"ajout.php?episode=".htmlentities($episode)."\">";
//echo "<br><br><A HREF=\"javascript:history.go(-1)\">Retour en arriere.</A>";
echo "<input name=\"description\" type=\"hidden\" readonly value=\"".$description."\">";
echo "<input name=\"titre\" readonly type=\"hidden\" value=\"".$titre."\">";
echo "<input name=\"retour\" readonly type=\"hidden\" value=\"true\">";



if (empty($_POST["choix"]))
{
echo "<br><b>Vous n'avez pas mis le nombre de choix possible !</b>";
echo "<br><br><input type=submit value=\"Retour en arriere\">";
echo "</form>";
}else
{
echo "<input name=\"choix\" readonly type=\"hidden\" value=\"".$nbrchoix."\">";
echo "<br><br><input type=submit value=\"Editer le post\"><br>(Attention, c'est votre dernière chance de modifier votre post. Relisez-le bien.)<hr><br><b>Choix :<br></b>";
echo "</form>";
echo "<form method=\"POST\" action=\"genererhtml.php?episode=".htmlentities($episode)."\">";
echo "<input name=\"description\" type=\"hidden\" readonly value=\"".$description."\">";
echo "<input name=\"titre\" readonly type=\"hidden\" value=\"".$titre."\">";
if ( is_numeric($nbrchoix) )
{ 
for ($i=0; $i!=$nbrchoix; $i++)
{
$lastnbr=$lastnbr+1;
//ne pas afficher $lastnbr dans les choix car quelqu'un peut prendre son temps pour ?rire un choix et se le faire voler
echo "<INPUT NAME=choix".$i." size=70% value=\"\"><br>
<small>(Si vous voulez revenir à un ancien post, mettez son numéro ici. Sinon laisez vide pour mener vers un nouveau post)</small><INPUT NAME=linkchoix".$i." size=10%><br><br>";
}
echo "<INPUT NAME=\"nbrchoix\" readonly type=\"hidden\" size=10% value=\"".$nbrchoix."\">";
echo "<br>Nom de l'auteur.-<INPUT NAME=\"auteur\" size=25%><br>";
echo "<br><br><input type=submit value=\"Terminer\">";
echo "</form>";
}
else{echo "Le nombre de choix doit être un nombre entier.";}
}
}
}
}
?>

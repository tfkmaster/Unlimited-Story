<?php 
header('Content-type: text/html; charset=UTF-8'); 
$episode = $_GET['episode'];
if ((!is_numeric($episode)) || ($episode<1)) 
{
	exit("[episode] type not valid");
}
$fb=fopen ("last.txt", "r");
$editableposts=fread ($fb, filesize("last.txt"));
fclose($fb);

$fepisode="posts/".htmlentities($episode).".html";
if (file_exists($fepisode)) 
{
	echo "This post already exist !";
}
else
{
	if ($episode>$editableposts) 
	{
		echo "This post cannot be created because no post is linked to it.<br><br>";
		echo "<a href=\"post.php?episode=1\">* Return to the begin of the story.</A>";
		echo "<br><br><a href=\"javascript:history.go(-1)\">* Go back.</p></a>";
	} 
	else 
	{
		if(empty($_POST["description"]) && empty($_POST["titre"]))
		{
			echo "The post have no content and title !";
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
			$file="posts/".htmlentities($episode).".html";
			$fp = fopen ($file, "w");
			$fb = fopen ("last.txt", "r+");
			$arbre = fopen ("storyline.txt", "a+");
			fputs ($arbre,"\r\n>".htmlentities($episode)."=");
			$lastnbr=fread ($fb, filesize("last.txt"));
			//We searching for the parent post
			$chparentarbre = fopen ("storyline.txt", "r");

			while (!feof ($chparentarbre )) 
			{
				$buffer = fgets($chparentarbre , 4096);
				$chparentarbretotal= $chparentarbretotal . $buffer;
			}
			//Get the parent episode
			$epmere=split(htmlentities($episode).";",$chparentarbretotal);
			//echo "episode mere0 :".$epmere[0]."<br>";
			$epmere=split(">",$epmere[0]);
			//$taillepemere=ubound($epmere);
			//echo "episode mere :".$epmere[sizeof($epmere)-1];
			$epmere=split("=",$epmere[sizeof($epmere)-1]);
			//echo "<bR>episode mere :".$epmere[0];
			//End Search
			fputs ($fp,"<head><meta http-equiv=\"Content-type\" content=\"text/html; charset=UTF-8\"/><title>Post ".htmlentities($episode)." - ".$titre."</title><link href=\"post.css\" rel=\"stylesheet\" type=\"text/css\"></head><p align=right>Parent post : <a href=\"".$epmere[0].".htm\">".$epmere[0]."</a></p><div class=\"general\"><div class=\"titre\"><H1>".$titre."</H1></div><div class=\"episode\">Post ".htmlentities($episode)."</div><hr><br><div class=\"description\">".$description."<br></div><hr><div class=\"liens\">");
			$nbrchoix=$_POST["nbrchoix"];
			for ($i=0; $i!=$nbrchoix; $i++)
			{
				$choix=$_POST["choix".$i];
				$linkchoix=$_POST["linkchoix".$i];
				if ( is_numeric($linkchoix) )
				{
					$choix = htmlspecialchars($choix, ENT_QUOTES);
					$choix=stripslashes($choix) ;
				}
				else
				{
					$linkchoix="";
					$choix = htmlspecialchars($choix, ENT_QUOTES);
				}
				$choix=stripslashes($choix) ;
				if(empty($choix))
				{}
				else
				{
					if(empty($linkchoix))
					{
						$lastnbr++;
						fputs ($arbre,$lastnbr.";");
						fputs ($fp,"<a href=\"../post.php?episode=".$lastnbr."\">".$choix."</a><br>");
					}
					else
					{
						if($linkchoix==$lastnbr)
						{
							fputs ($arbre,$linkchoix.";");
							fputs ($fp,"<a href=\"../post.php?episode=".$linkchoix."\">".$choix."</a><br>");
						}
						if($linkchoix>$lastnbr)
						{
							$lastnbr++;
							fputs ($arbre,$lastnbr.";");
							fputs ($fp,"<a href=\"../post.php?episode=".$lastnbr."\">".$choix."</a><br>");
						}
						if($linkchoix<$lastnbr)
						{
							fputs ($arbre,$linkchoix.";");
							fputs ($fp,"<a href=\"../post.php?episode=".$linkchoix."\">".$choix."</a><br>");
						}
					}
					fseek($fb,0); 
					fputs ($fb,$lastnbr);
				}
			}
			if(empty($_POST["auteur"]))
			{
				fputs ($fp,"</div></div>");
			}
			else
			{
				$auteur=$_POST["auteur"];
				$auteur=stripslashes($auteur);
				$auteur = htmlspecialchars($auteur, ENT_QUOTES);
				fputs ($fp,"</div></div><hr><div class=\"auteur\">".$auteur."</div>");
				$auteur=str_replace ("[", "", $auteur);
				$auteur=str_replace ("]", "", $auteur);
				$auteur=str_replace ("{", "", $auteur);
				$auteur=str_replace ("}", "", $auteur);
				fputs ($arbre,"[".$auteur."]");
			}
			if(empty($_POST["titre"]))
			{}
			else
			{
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
			Echo "Post successfully created !<br><br><a href=\"post.php?episode=".htmlentities($episode)."\">Watch the post.</a>";
		}
	}
}
?>
<?php
header('Content-type: text/html; charset=UTF-8'); 
$etatepisode="";
$episode = $_GET['episode'];
if ((!is_numeric($episode)) || ($episode<1)) 
{
	exit("[episode] type not valid");
}

if(empty($_POST['retour'])) 
{
	$retour="";
}
else
{
	$retour = $_POST['retour'];
}
if(empty($_POST['description'])) 
{
	$description="";
}
else
{
	$description = $_POST['description'];
	$description=stripslashes($description);
}
if(empty($_POST['titre'])) 
{
	$titre="";
}
else
{
	$titre = $_POST['titre'];
	$titre=stripslashes($titre);
}
if(empty($_POST['choix'])) 
{
	$choix="";
}
else
{
	$choix = $_POST['choix'];
}
$fp = fopen ("last.txt", "r");
$n_dernier = fread ($fp, filesize("last.txt"));
fclose ($fp);

$fepisode="posts/".htmlentities($episode).".html";
if ($episode>$n_dernier)
{
	$etatepisode="outofrange";
	$retour="true";
}

if ($retour!="true")
{
	if (file_exists($fepisode)) 
	{
	    //If the post exist
		$etatepisode="This post already exist.";
		echo "This post already exist !";
	} 
	else 
	{
		$file="create".htmlentities($episode).".html";
		if (file_exists($file)) 
		{
		    //The post is in progress
			$date_fic=filemtime($file);
			//echo "heureafichier".$date_fic;
			//Compare the date of creation and the current date'
			//$date_fic=date("d/m/Y h:i:s", filemtime($file));
			
			$heureactuelle=time();
			//echo "heureactuelle".$heureactuelle;
			$heureactuelle=$heureactuelle-$date_fic;
			//echo "difference".$heureactuelle;
			if ($heureactuelle>900 or $heureactuelle<2)
			{
				//If the file is older than 15 minutes (900s) we replace it
				$file="create".htmlentities($episode).".html";
			    unlink($file); 
				$fp = fopen ($file, "w");
			    fclose ($fp);
			}
			else
			{
				$heureactuelle=	900-$heureactuelle
				$etatepisode="inprogress";
				echo "<br>This post is in writing process, don't hesitate to retry later if the author abandonned it (he have 15 minutes to publish the post).";
				echo $heureactuelle." seconds before unlock"
				echo "<br><br><a href=\"javascript:history.go(-1)\">Go back</p></a>";
			} 
		}
		else 
		{
			// If it don't exist
			$fp2 = fopen ($file, "w");
			fclose ($fp2);
		}
	}
}

if($etatepisode=="outofrange") 
{
	echo "This post cannot be created because no post is linked to it.<br><br>";
	echo "<a href=\"post.php?episode=1\">* Return to the begin of the story.</A>";
	echo "<br><br><a href=\"javascript:history.go(-1)\">* Go back.</p></a>";
}
else if($etatepisode!="inprogress")
{
	echo "<br></b><b>Post n°";
	echo htmlentities($episode)." :"; 
	echo "<form method=\"POST\" action=\"addfinal.php?episode=".htmlentities($episode)."\">";
	echo "</b> You can give a title to your post (recommanded)<br> <INPUT NAME=\"titre\" size=70% value=\"".$titre."\">
	<br>
	<br>
	Post content :
	<br>
	<textarea name=\"description\" rows=10 cols=80 >".$etatepisode.$description."</textarea>
	<br>
	Styles Tags :
	[b]<b>bold</b>[/b] | [i]<i>italic</i>[/i] | [u]<u>underline</u>[/u] | [s]<s>strike</s>[/s] | [img]Picture URL[/img]
	<br>
	<br>
	Number of player choices ";
	echo "<INPUT NAME=\"choix\" size=10% value=\"".$choix."\">
	<br>
	<br>
	<input type=submit value=\"Confirm\"> - Continue the post process.
	<br>
	(Thanks to write wisely).
	<hr>
	</form>
	<a href=\"javascript:history.go(-1)\">Go back</a>
	<br>";
} 
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>TITLE HERE</title>
<link href="indexstyle.css" rel="stylesheet" type="text/css">
</head>

<body><p align=right>Parent post : <a href="index.php">index</a></p><center>

<?php
//on ouvre tout le fichier
$filetotal="";
$auteur = $_GET['auteur'];
$lecture=fopen("storyline.txt","r");
$auteur=stripslashes($auteur);
$auteur = htmlspecialchars($auteur, ENT_QUOTES);
$tentativepirate=false;
$auteurtrouve=false; 

if(strpos($auteur,"&lt;")!==false){$tentativepirate=true;}
if(strpos($auteur,"&gt;")!==false){$tentativepirate=true;}
if(strpos($auteur,"echo")!==false){$tentativepirate=true;}
if($tentativepirate==true)
{
	echo "I think you just trying to hack us nope ? :D <br>";
}

echo "Searching for the author : ".$auteur."<br>";
//Read storyline until the end
while (!feof ($lecture)) 
{
	$ligne= fgets($lecture, 1024);
	//Find the post by finding the author of it
	if (preg_match("[".$auteur."]", $ligne))
	{
		$auteurtrouve=true; 
		//echo "<br>".$ligne;

		//Get post number
		$coup=split("=", $ligne);
		$coup=split(">", $coup[0]);
		echo "<br><a href=p1/".$coup[1].".html>Post n°".$coup[1]."</a>";

		//Get the post title
		$nepisode=explode("{",$ligne);
		//Check if title exist
		if(empty($nepisode[1])) 
		{}
		else
		{
		//Check if title size exceed the limit
			if (strlen($nepisode[1])>200)
			{
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
echo "The author was not found.";
}
?>
</center></body></html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>All posts</title>
<link href="indexstyle.css" rel="stylesheet" type="text/css">
</head>
All posts
<?php
$filetotal="";
$fd=fopen("storyline.txt","r");
while (!feof ($fd)) 
{
	$buffer = fgets($fd);
	$filetotal= $filetotal . $buffer;
}
//Put each lines(Exemple: >43=2;50;53;) in array
$tabcoup=explode(">",$filetotal);
//Get the array size
$taille=count($tabcoup);

echo " (".$taille.") :";
for ($i=$taille; $i!=0; $i--)
{
	//Get the post number
	$nepisode=explode("=",$tabcoup[$taille-$i]);
	echo "<br><a href=posts/".$nepisode[0].".html>Post n°". $nepisode[0];
	//Get the post title
	$nepisode=explode("{",$tabcoup[$taille-$i]);
	//Check if title exist
	if(empty($nepisode[1])) 
	{}
	else
	{
		// Truncate the post title if it's too long
		if (strlen($nepisode[1])>40)
		{
			$nepisode[1] = substr($nepisode[1], 0, 40);
			$nepisode[1]=$nepisode[1]."...";
		}

		$nepisode=explode("}",$nepisode[1]);
		echo " : ". $nepisode[0];
	}
	echo "</a>";
	//Get the author name
	$nepisode=explode("[",$tabcoup[$taille-$i]);
	//Check if author name exist
	if(empty($nepisode[1])) 
	{}
	else
	{
		$nepisode=explode("]",$nepisode[1]);
		echo  "<i> par ".$nepisode[0]."</i>";
	}
}
?>
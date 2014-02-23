<?php 
header('Content-type: text/html; charset=UTF-8'); 
$episode = $_GET['episode'];
if ((!is_numeric($episode)) || ($episode<1)) 
{
	exit("[episode] type not valid");
}

$fepisode="p1/".htmlentities($episode).".html";
$fb=fopen ("last.txt", "r");
$editableposts=fread ($fb, filesize("last.txt"));
fclose($fb);

if ($episode>$editableposts) 
{
	echo "This post cannot be created because no post is linked to it.<br><br>";
	echo "<a href=\"post.php?episode=1\">* Return to the begin of the story.</A>";
	echo "<br><br><a href=\"javascript:history.go(-1)\">* Go back.</p></a>";
} 
elseif (file_exists($fepisode)) 
{
	header("Location: p1/".htmlentities($episode).".html")    ;
} 
else 
{
	echo "Post n°".htmlentities($episode)." :"; 
	//If the post doesn't exist
	echo " :<br><br>There's no post here. Don't hesitate to create one !<br><br>";
	echo "<a href=\"add.php?episode=".htmlentities($episode)."\">* Create the post.</A>";
	echo "<br><br><a href=\"javascript:history.go(-1)\">* Don't create a post and go back.</p></a>";
}
?>
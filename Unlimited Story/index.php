<html>
<head><title>TITLE HERE</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="indexstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<center>
<h1>Unlimited Story</h1>
<h3>Story created by users, for users, forever...</h3></center>

<div class="players"><b>The book of players :</b><br>
<a href="post.php?episode=1">Start the story from the beginning</a><br><br>
<p>10 last posts</p><br>

<?
$filetotal="";
$fd=fopen("storyline.txt","r");

while (!feof ($fd)) 
{
	$buffer = fgets($fd);
	$filetotal= $filetotal . $buffer;
}

//Put lines( >43=2;50;53;) in array 'coup'
$tabcoup=explode(">",$filetotal);
//Get the size of the array
$taille=count($tabcoup);
?>

<?
for ($i=10; $i!=0; $i--)
{

	//Get the post number
	$nepisode=explode("=",$tabcoup[$taille-$i]);
	echo "<br><a href=p1/".$nepisode[0].".html>Post n°". $nepisode[0];
	//Get the post title
	$nepisode=explode("{",$tabcoup[$taille-$i]);

	//Check is the post have title
	if(empty($nepisode[1])) 
	{}
	else
	{
		// Check if title size exceed the limit
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

	//Check if the post have author
	if(empty($nepisode[1])) {}
	else{
		$nepisode=explode("]",$nepisode[1]);
		echo  "<i> par ".$nepisode[0]."</i>";
	}

}
?>

<br><br><a href="last100.php">Last 100 posts</a><br><br>
<a href="storyline.txt">The storyline in text format</a>
</div>

<div class="authors">
<b>The authors table</b>
<br><a href="FAQ.php">FAQ</a><br><br>
<b><u>Authors leaderboard :</b></u>

<?
$tabauteurclassement[0]="";
$tabnumclassement[0]=0;
$tabauteurclassement[1]="";
$tabnumclassement[1]=0;

//Searching for author names in the entire array
for ($i=1; $i!=$taille;  $i++)
{

	//echo "<br>test ".$tabcoup[$i];
	//if there is "[", we've found a author, so we need to split it
	if (preg_match("/\[/",$tabcoup[$i]))
	{
		$auteur=preg_split("/\[/",$tabcoup[$i]);
		$auteur=preg_split("/\]/",$auteur[1]);
		$auteur[1]=$auteur[0];
		//echo "<br>AUTHOR : ".$auteur[1];
		//Add the author in the list if he's not currently in
		if (!preg_match("/".$auteur[1]."/",$listeauteur))
		{
			//echo "<br>AUTHOR ADDED : ".$auteur[1];
			$listeauteur=$listeauteur.$auteur[1];
			//Add the author in the author array
			$tabauteur[]=$auteur[1];
		}
	}

}

//Sorting of the author list
//echo "Author list :".$listeauteur;
//echo "AuthorArray Size : ".count($tabauteur);

//Now, we need to find how many time the author appeared in the storyline

for ($j=0; $j!=5;  $j++)
{

//For every author
	for ($i=0; $i<count($tabauteur); $i++){
	//Count the occurrence number in the storyline
	//echo "Name : ".$tabauteur[$i]." Occurrence : ".substr_count($filetotal,$tabauteur[$i])."<br>";

	//If the number of occurrence is greater than the last author, we replace it
		if (substr_count($filetotal,$tabauteur[$i])>$tabnumclassement[$j])
		{
		//Only if the author isn't in leaderboard
			if(!preg_match("/".$tabauteur[$i]."/",$podium))
			{
			$tabauteurclassement[$j]=$tabauteur[$i];
			$tabnumclassement[$j]=substr_count($filetotal,"[".$tabauteur[$i]."]");
			}
		}		
	}
	
//Then, the author who have the most occurrence is placed in the top of leaderboard
$podium=$podium.$tabauteurclassement[$j].$tabnumclassement[$j];
//echo "Leaderboard ".$podium;
echo "<br><br><b>".($j+1).".</b> <a href=\"authorsearch.php?auteur=".$tabauteurclassement[$j]."\">".$tabauteurclassement[$j]."</a><br>"."(".$tabnumclassement[$j]." Posts)";

}
?>

<br><br>A little thanks message for everyone :3<br>
</div><br><br>

</body></html>
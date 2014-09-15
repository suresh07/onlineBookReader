<?php
	$index = $_GET['index'];
	$reduce = round($_GET['reduce']);
	$book = $_POST['book'];
	$project = "5804";
	
	if($reduce >= 2)
	{
		$imgurl = "../img/3";
		$imgurl2 = "img/3";
		$scale = 700;
	}
	else if($reduce == 1)
	{
		$imgurl = "../img/2";
		$imgurl2= "img/2";
		$scale = 1400;
	}
	else if($reduce <= 1)
	{
		$imgurl = "../img/1";
		$imgurl2 = "img/1";
		$scale = 2100;
	}
			
	$djvurl = "../Volumes/".$project;
	$tifurl = "../tif";
	
	$img = split("\.",$book[$index]);
	if(!file_exists($tifurl."/".$img[0].".tif"))
	{
		$cmd = "ddjvu -format=tif ".$djvurl."/".$img[0].".djvu ".$tifurl."/".$img[0].".tif";
		exec($cmd);
	}
	if(!file_exists($imgurl."/".$img[0].".jpg"))
	{
		$cmd="convert $tifurl/".$img[0].".tif -resize x".$scale." $imgurl/".$img[0].".jpg";
		exec($cmd);
	}
	
	//~ Update manifest file to download the request file.
	$myfile = fopen("appcache.manifest", "w") or die("Unable to open file!");
	fwrite($myfile,"CACHE MANIFEST\n");
	fwrite($myfile,$imgurl."/".$img[0].".jpg");
	fwrite($myfile,"\n\nNETWORK:\n*\n");
	fwrite($myfile,"FALLBACK:\n");
	fclose($myfile);
	//~ exec("php remove.php");
	//~ $myfile = fopen("remove.php", "w") or die("Unable to open file!");
	//~ $cmd = "rm ".$imgurl."/".$img[0].".jpg";
?>

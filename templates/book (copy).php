<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>
<head>
    <title>$book['Title']</title>
    
    <link rel="stylesheet" type="text/css" href="../static/BookReader/BookReader.css"/>
    <!-- Custom CSS overrides -->
    <link rel="stylesheet" type="text/css" href="../static/BookReaderDemo.css"/>

    <script type="text/javascript" src="../static/BookReader/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="../static/BookReader/jquery-ui-1.8.5.custom.min.js"></script>

    <script type="text/javascript" src="../static/BookReader/dragscrollable.js"></script>
    <script type="text/javascript" src="../static/BookReader/jquery.colorbox-min.js"></script>
    <script type="text/javascript" src="../static/BookReader/jquery.ui.ipad.js"></script>
    <script type="text/javascript" src="../static/BookReader/jquery.bt.min.js"></script>
    <script type="text/javascript" src="../static/BookReader/BookReader.js"></script>
    <?php
		//~ $project = $_GET['projectid'];
		$project = "5804";
			
		$djvurl = "../Volumes/".$project;
		$tifurl = "../tif";
		$imgurl = "../img";
		
		$cmd = "djvmcvt -i $djvurl/index.djvu $djvurl index.djvu";
		system($cmd);
		
		$djvulist=scandir($djvurl);
		$cmd='';
		
		for($i=0;$i<count($djvulist);$i++)
		{
			if($djvulist[$i] != '.' && $djvulist[$i] != '..' && preg_match('/(\.djvu)/' , $djvulist[$i]) && !preg_match('/(index\.djvu)/' , $djvulist[$i]))
			{
				$img = split("\.",$djvulist[$i]);
				$cmd = "ddjvu -format=tif ".$djvurl."/".$djvulist[$i]." $tifurl/".$img[0].".tif";
				system($cmd);
				$cmd="convert $tifurl/".$img[0].".tif p -resize x700 ../img/".$img[0].".jpg";
				system($cmd);
				$book["imglist"][$i]= $img[0].".jpg";
			}
		}
	
		$book["imglist"]=array_values($book["imglist"]);
		$book["Title"] = "Online Book Reader";
		$book["TotalPages"] = count($book["imglist"]);
		$book["SourceURL"] = "";
    ?>
    <script type="text/javascript">
		var book = <?php echo json_encode($book); ?>;
	</script>
</head>
<body style="background-color: ##939598;">

<div id="BookReader">
    Internet Archive BookReader Demo    <br/>
    
    <noscript>
    <p>
        The BookReader requires JavaScript to be enabled. Please check that your browser supports JavaScript and that it is enabled in the browser settings.  You can also try one of the <a href="http://www.archive.org/details/goodytwoshoes00newyiala"> other formats of the book</a>.
    </p>
    </noscript>
</div>

<script type="text/javascript" src="../static/BookReaderJSSimple.js"></script>

</body>
</html>

<?php

require('var.php');

?>

<html>

        <head>
		<title> Random Webms </title>
		<link rel="icon" type="image/png" href="favicon.ico">
		<link rel="stylesheet" type="text/css" href="media/style.css">

        </head>
        
	<body>
		<?php

			echo "<div id='page-width'>";
			echo "<center><video controls autoplay loop id='vid'>";
			echo "<source src='uploads/" . $random . ".webm' type='video/webm'/>";
			echo "</video>";
			echo "</center>";
			echo "<hr>";
			echo "<div id='mssg'>This page displays a random .webm file from the database, refresh the page (or press F5) for a new one.</div>";
			echo "<div id='upload-wrapper'>";
			echo "<form action='upload_file.php' method='post' enctype='multipart/form-data'><input type='file' name='uploaded_file'><input type='submit' value='Upload file'>"; 
			echo "<ul id='list'><li>.webm files only</li><li>File size must be under <b>5MB's</b></li><li>Audio is allowed</li><li>Have fun</li></ul>";
			echo "</div>";
			echo "</div>";

		?>	
	</body>
</html>
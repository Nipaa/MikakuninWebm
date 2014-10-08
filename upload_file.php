 <?php

	// Connect to the database

		$dbLink = new mysqli('localhost', 'username', 'password', 'database');
        	if(mysqli_connect_errno()) {
            	die("MySQL connection failed: ". mysqli_connect_error());
        	}
 
        // Gather all required data
        $name = $dbLink->real_escape_string($_FILES['uploaded_file']['name']);
        $mime = $dbLink->real_escape_string($_FILES['uploaded_file']['type']);
        $size = intval($_FILES['uploaded_file']['size']);


	//If the file type is not a webm, kill the upload
		if ($mime != 'video/webm'){
			die("webm's only");			
			}


	// Set local PHP vars from the POST vars sent from our form using the array
	// of data that the $_FILES global variable contains for this uploaded file
		$fileName = $_FILES["uploaded_file"]["name"]; // The file name
		$fileTmpLoc = $_FILES["uploaded_file"]["tmp_name"]; // File in the PHP tmp folder
		$fileType = $_FILES["uploaded_file"]["type"]; // The type of file it is
		$fileSize = $_FILES["uploaded_file"]["size"]; // File size in bytes
		$fileErrorMsg = $_FILES["uploaded_file"]["error"]; // 0 for false... and 1 for true

	// Specific Error Handling
		if (!$fileTmpLoc) { // if file not chosen
    			echo "ERROR: Please browse for a file before clicking the upload button.";
    			exit();
			} else if($fileSize > 5242880) { // if file is larger than we want to allow
    				echo "ERROR: Your file was larger than 5mb's in file size.";
    				unlink($fileTmpLoc);
    				exit();
				} else if (!preg_match("/.(webm)$/i", $fileName) ) {
     					// This condition is only if you wish to allow uploading of specific file types    
     					echo "ERROR: Your image was not .webm.";
     					unlink($fileTmpLoc);
    					exit();
					}

	// Place it into your "uploads" folder
		move_uploaded_file($fileTmpLoc, "uploads/$fileName");

	// Check to make sure the uploaded file is in place where you want it
		if (!file_exists("uploads/$fileName")) {
    			echo "ERROR: File not uploaded<br /><br />";
    			echo "Check folder permissions on the target uploads folder is 0755 or looser.<br /><br />";
    			echo "Check that your php.ini settings are set to allow over 2 MB files, they are 2MB by default.";
    			exit();
			}

	/* Display things to the page so you can see what is happening for testing purposes
		echo "The file named <strong>$fileName</strong> uploaded successfuly.<br /><br />";
		echo "It is <strong>$fileSize</strong> bytes in size.<br /><br />";
		echo "It is a <strong>$fileType</strong> type of file.<br /><br />";
		echo "The Error Message output for this upload is: <br />$fileErrorMsg";
	*/

	// Create the SQL query
        	$query = " INSERT INTO `tablename` ( `name`, `mime`, `size`, `created` ) VALUES ( '{$name}', '{$mime}', {$size}, NOW() )";

        // Execute the query
        	$result = $dbLink->query($query);
 
        // Check if it was successfull
        	if($result) {
            	echo 'Success! Your file was successfully added!';
        	}
        	else {
            		echo 'Error! Failed to insert the file'
               		. "<pre>{$dbLink->error}</pre>";
        		}

	//Time to rename the file on the server with the id in our database.
	//This helps with the method used to randomly display a file.

		$image1Oldname = "uploads/" . $fileName;
		$image1NewName = "uploads/" . mysqli_insert_id($dbLink) . ".webm";
		var_dump($image1Oldname, $image1NewName);
		rename($image1Oldname, $image1NewName);

	// Close the mysql connection
		$dbLink->close();

	//Now back to home
		header ('Location: index.php');

?>
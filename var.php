<?php

	//Connect to the database
		$dbLink = new mysqli('localhost', 'username', 'password', 'database');
		if(mysqli_connect_errno()) {
		die("MySQL connection failed: ". mysqli_connect_error());
		}

	//Randomly select an id from the database.
		srand(time());
		$result = $dbLink->query("SELECT MAX(id) FROM table");
		while($row=$result->fetch_row()) { $count = $row[0]; }
		$random = rand(1,$count);

	//Close the mysql connection
		mysqli_close($dbLink);

?>
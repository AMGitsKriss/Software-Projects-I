<?php
/*
 *	NOT INTENDED TO BE ACCESSED FROM ANYWHERE ON DIRE
 *	DIRECT ACCESS ONLY
 *
 *	Database encoding: utf8_general_ci
 */

	require("db_connect.php");

	$sql = "CREATE TABLE Users (user_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, name VARCHAR(30) NOT NULL, email VARCHAR(100), password VARCHAR(100), reg_date TIMESTAMP);";

	$sql .= "";

	//Applying the sql
	if ($conn->query($sql) === TRUE) {
		spit( "Table MyGuests created successfully" );
	} else {
		spit( "Error creating table: " . $conn->error );
	}

	$conn->close();
?>

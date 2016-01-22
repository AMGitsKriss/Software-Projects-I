<?php
/*
 *	NOT INTENDED TO BE ACCESSED FROM ANYWHERE ONLINE
 *	DIRECT ACCESS ONLY
 */

	require("db_connect.php");

			//Username as primary key prevents duplicates
	$sql = "CREATE TABLE Users (name VARCHAR(50) NOT NULL PRIMARY KEY, email VARCHAR(100), password VARCHAR(100), reg_date TIMESTAMP);";

	$sql .= "";

	//Applying the sql
	if ($conn->query($sql) === TRUE) {
		spit( "Table MyGuests created successfully" );
	} else {
		spit( "Error creating table: " . $conn->error );
	}

	$conn->close();
?>
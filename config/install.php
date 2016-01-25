<?php
/*
 *	NOT INTENDED TO BE ACCESSED FROM ANYWHERE ONLINE
 *	DIRECT ACCESS ONLY
 *	Ensure databaseaccess is general_ci
 */

	//TODO (Kriss) - This installer doesn't work. Use temp.sql instead.

	require("db_connect.php");

			//Username as primary key prevents duplicates
	$sql = "CREATE TABLE Users (name VARCHAR(100) NOT NULL PRIMARY KEY, email VARCHAR(100), password VARCHAR(100), reg_date TIMESTAMP); \n";

	$sql .= "CREATE TABLE Posts (postid INT AUTO_INCREMENT, added TIMESTAMP DEFAULT CURRENT_TIMESTAMP, name VARCHAR(100), url VARCHAR(255), owner VARCHAR(100), ip VARCHAR(15), PRIMARY KEY(postid), FOREIGN KEY(owner) REFERENCES Users(name)); ";
			//Group name as primary key to prevent duplicate tagnames
	$sql .= "CREATE TABLE Groups (name VARCHAR(100) NOT NULL PRIMARY KEY); \n";

	$sql .= "CREATE TABLE GroupMembers (groupid VARCHAR(100), userid VARCHAR(100), FOREIGN KEY (groupid) REFERENCES Groups(name), FOREIGN KEY (userid) REFERENCES Users(name)); \n";
			//Tag name as primary key to prevent duplicate tagnames
	$sql .= "CREATE TABLE Tags (name VARCHAR(100) NOT NULL PRIMARY KEY); \n";

	$sql .= "CREATE TABLE TagMambers (tagid VARCHAR(100), postid INT(6), FOREIGN KEY (tagid) REFERENCES Tags(name), FOREIGN KEY (postid) REFERENCES Posts(postid)); \n";

	$sql .= "CREATE TABLE GroupPosts (postid INT, groupid VARCHAR(100), FOREIGN KEY (groupid) REFERENCES Groups(name), FOREIGN KEY (postid) REFERENCES Posts(postid)); \n";

	echo $sql ."</br>";

	//Applying the sql
	if ($conn->query($sql) === TRUE) {
		echo( "Table MyGuests created successfully" );
	} else {
		echo( "Error creating table: " . $conn->error );
	}

	$conn->close();
?>
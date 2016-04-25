<?php
/*
 *	NOT INTENDED TO BE ACCESSED FROM ANYWHERE ONLINE
 *	DIRECT ACCESS ONLY
 *	Ensure database access is general_ci
 */

	error_reporting(E_ALL);
	ini_set('display_errors', true);

	require("db_connect.php");
		//Username as primary key prevents duplicates
		//Group name as primary key to prevent duplicate tagnames
		//Tag name as primary key to prevent duplicate tagnames
	$sql = array(

"CREATE TABLE Users (name VARCHAR(100) NOT NULL PRIMARY KEY, email VARCHAR(100), password VARCHAR(100), reg_date TIMESTAMP, permissions TINYINT(1) NOT NULL DEFAULT '0')",

"CREATE TABLE Posts (postid INT AUTO_INCREMENT, added TIMESTAMP DEFAULT CURRENT_TIMESTAMP, postname VARCHAR(100), url VARCHAR(255), owner VARCHAR(100), ip VARCHAR(15), colour VARCHAR(20) DEFAULT 'lavender', PRIMARY KEY(postid), FOREIGN KEY(owner) REFERENCES Users(name))",

"CREATE TABLE Groups (name VARCHAR(100) NOT NULL PRIMARY KEY, private TINYINT(1) DEFAULT '0', owner VARCHAR(100), FOREIGN KEY(owner) REFERENCES Users(name))",

"CREATE TABLE GroupMembers (groupid VARCHAR(100), userid VARCHAR(100), FOREIGN KEY (groupid) REFERENCES Groups(name), FOREIGN KEY (userid) REFERENCES Users(name))",

"CREATE TABLE GroupPosts (postid INT, groupid VARCHAR(100), FOREIGN KEY (groupid) REFERENCES Groups(name), FOREIGN KEY (postid) REFERENCES Posts(postid))");
	//Applying the sql
	for($i = 0; $i < count($sql); $i++){
		if ($conn->query($sql[$i]) === TRUE) {
			echo( "Row " . $i . " created successfully" );
		} else {
			echo( "Error creating table " . $i . " : " . $conn->error );
		}
	}

	$conn->close();
?>

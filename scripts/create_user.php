<?php 
	//TODO - ADD EMAIL FIELD TO THE ABOVE FORM
	error_reporting(E_ALL);
	ini_set('display_errors', true);
	
	require("config/db_connect.php");
	include("functions.php");
	require("libs/PasswordHash.php");
	
	//Starting the Hasher, and declaring the password variable 
	$hasher = new PasswordHash(8, false);
	$password = "*";

	//Assuming this is a pust submission
	if(isset($_POST['submit'])){

		echo "<h2> Error: </h2>";

		//If the password's DONT match, spit it back. 
		if($_POST['password1'] !== $_POST['password2']){
			spit( "Passwords don't match." );
		}
		//Do a check to make sure address is an email.
		else if(!validEmail($_POST['email'])){
			spit( "Email not valid." );
		}
		//If all fields are filled in appropriately
		else if(strlen($_POST['password1'])>=6 && strlen($_POST['username'])>=4 && validEmail($_POST['email'])){
			// Create connection
			$conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			$email = $_POST['email'];
			$username = $_POST['username'];
			$password = $_POST['password1'];
			// To protect MySQL injection for Security purpose
			$email = stripslashes($email);
			$username = stripslashes($username);
			$password = stripslashes($password);
			
			$email = $conn->real_escape_string($email);
			$username = $conn->real_escape_string($username);
			$password = $conn->real_escape_string($password);
			
			if(strlen($password) > 72){
				die("Password must be 72 characters or less.");
			}
			
			$password = $hasher->HashPassword($password);
			//Minimum hash length is 20 characters. If less, something's broken.
			if(strlen($password) >= 20 && !checkUsername($username, $conn)){	//TODO - Also check the email address isn't used.
				//Hashing has worked and there's no existing user by that name.
				//Add the entry and go to the login page.
				$sql = "INSERT INTO Users (username, password, email) VALUES ('$username', '$password', $email)";
				$conn->query($sql);
				header("location:form.php");
			} 
			//Found that username already
			else if(checkUsername($username, $conn)){ //Username exists
				spit( "That username is already in use." );
			}
			//Email already exists
			else if(checkEmail($email, $conn)){ //Username exists
				spit( "That email is already in use." );
			}
			//Hashing was botched
			else if(strlen($password) < 20){ //Password too short
				spit( "Something went wrong." );
			}
			$conn->close();
		}
		else if(strlen($_POST['username'])<4){
			spit( "Username too short. " );
		}
		else if(strlen($_POST['password1'])<6){
			spit( "Password too short. " );
		}
	}
	//If not a post, go back up to index.php
	else {
		header("location: ../");
	}
?>
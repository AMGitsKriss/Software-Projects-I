<?php 
	//TODO - Merge this with register.html in a view/register.php file.

	error_reporting(E_ALL);
	ini_set('display_errors', true);

	//Assuming this is a post submission
	if(isset($_POST['submit'])){

		require("../functions.php");
		require("../config/db_connect.php");
		require("../libs/PasswordHash.php");
		
		//Starting the Hasher, and declaring the password variable 
		$hasher = new PasswordHash(8, false);
		$password = "*";

		$report = "<h2> Error: </h2>";

		//If the password's DONT match, spit it back. 
		if($_POST['password1'] !== $_POST['password2']){
			$report .= "<p>Passwords don't match.</p>";
		}
		//Do a check to make sure address is an email.
		else if(!validEmail($_POST['email'])){
			$report .= "<p>Email not valid.</p>";
		}
		//If all fields are filled in appropriately
		else if(strlen($_POST['password1'])>=6 && strlen($_POST['name'])>=4 && validEmail($_POST['email'])){
			$email = $_POST['email'];
			$username = $_POST['name'];
			$password = $_POST['password1'];
			// To protect MySQL injection for Security purpose
			$username = stripslashes($username);
			
			$email = $conn->real_escape_string($email);
			$username = $conn->real_escape_string($username);
			$password = $conn->real_escape_string($password);
			
			if(strlen($password) > 72){
				die("Password must be 72 characters or less.");
			}
			
			$password = $hasher->HashPassword($password);

			//Minimum hash length is 20 characters. If less, something's broken.
			if(strlen($password) >= 20 ){	
				//Hashing has worked.
				//Add the entry and go to the login page.
				$sql = "INSERT INTO Users (name, password, email) VALUES ('$username', '$password', '$email')";
				$query = mysqli_query($conn, $sql);
				if(!$query){
					echo $conn->error;
					
				}
				else{
					header("location: ../index.php?");
				}
			} 
			//Found that username already
			else if(checkUsername($username)){ //Username exists
				$report .= "<p>That username is already in use.</p>";
				echo $report;
			}
			//Email already exists
			else if(checkEmail($email)){ //User has account
				$report .= "<p>That email is already in use.</p>";
				echo $report;
			}
			//Hashing was botched
			else if(strlen($password) < 20){ //Password too short
				$report .= "<p>Something went wrong.</p>";
				echo $report;
			}
			$conn->close();
		}
		else if(strlen($_POST['username'])<4){
			$report .= "<p>Username too short.</p>";
		}
		else if(strlen($_POST['password1'])<6){
			$report .= "<p>Password too short.</p>";
		}
	}
	//If not a post, go back up to index.php
	else {
		header("location: ../");
	}
?>
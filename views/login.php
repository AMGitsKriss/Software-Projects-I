<?php

	/*
	 *	This file contains the login script, and displays both the login and registration forms.
	 *	If a new user is created, it calls that script via POST astion.
	 */

	//Add login and registration divs to output
	//TODO - Make these windows show side-by-side with CSS
	$output .= file_get_contents('templates/login.html');
	$output .= file_get_contents('templates/register.html');

	// ------- START form processing code... -------

	// define variables and set to empty values
	$username = $password = "";

	//TODO Adonay/Kriss - Check to see if the user has a permission level of 1. If so, show them the admin UI.

	// check if there was a POST request
	if (isset($_POST['login'])) {
		//create the hasher
		require("libs/PasswordHash.php");
		$hasher = new PasswordHash(8, false);

		// validate the form data
		if (empty($_POST["username"]) || empty($_POST["password"])) {
	   	 	//If neither field's been entered
	  	} 
		else if (!empty($_POST["username"]) && !empty($_POST["password"])){
			//If both fields have content.
			//TODO Kriss - Hash and compare the passwords before continuing.
	    	$username = $_POST["username"];
			$password = $_POST["password"];
			
			//Username is key value. Can only be one.
			$select = "SELECT * FROM users WHERE name = '$username'";
			$result = mysqli_query($conn, $select);

			$check_user = 0;
			if($result == false){
				spit("User not found.");
				$saved_username = "";
				$hashed_pass = "";
			}
			else{
				//get row data, then remember the password for comparison
				while($row = mysqli_fetch_assoc($result)){
					$saved_username = $row['name'];
					$hashed_pass = $row['password'];
					$check_user = mysqli_num_rows($result);
					$permission = $row['permissions'];
					$userColour = $row['colour'];
				}
			}

			//If there is 1 matching user (which there should be) and the password check returns true...
		 	if($check_user == 1 && $hasher->CheckPassword($password, $hashed_pass))
		 	{
		 		//Login
		 		$_SESSION['login'] = "true";
		 		$_SESSION['username'] = $saved_username;
		 		$_SESSION['admin'] = ($permission == 0) ? FALSE : TRUE;
		 		$_SESSION['colour'] = $userColour;
				header('Location: '.$host);
			}
			else{

				//changed from spit to echo. maybe add CSS?
				echo '<p>!!Login failed!! Please try again</p>';
			}

		// ------- END form processing code... -------
		}
	}
	//Assuming this is a register submission
	if(isset($_POST['register'])){

		//Starting the Hasher, and declaring the password variable 
		require("libs/PasswordHash.php");
		$hasher = new PasswordHash(8, false);
		$password = "*";

		$output = generateHeader("Sign in", true);
		$output .= file_get_contents('templates/login.html');
		$output .= file_get_contents('templates/register.html');
		$output .= "<h2> Error: </h2>";

		//If the password's DONT match, spit it back. 
		if($_POST['password1'] !== $_POST['password2']){
			$output .= "<p>Passwords don't match.</p>";
		}
		//Do a check to make sure address is an email.
		else if(!validEmail($_POST['email'])){
			$output .= "<p>Email not valid.</p>";
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
				$output .= "<p>That username is already in use.</p>";
				echo $output;
			}
			//Email already exists
			else if(checkEmail($email)){ //User has account
				$output .= "<p>That email is already in use.</p>";
				echo $output;
			}
			//Hashing was botched
			else if(strlen($password) < 20){ //Password too short
				$output .= "<p>Something went wrong.</p>";
				echo $output;
			}
			$conn->close();
		}
		else if(strlen($_POST['name'])<4){#
			$output .= "<p>Username too short.</p>";
		}
		else if(strlen($_POST['password1'])<6){
			$output .= "<p>Password too short.</p>";
		}
	}
?>
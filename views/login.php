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
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

			if($result == false){
				spit("User not found.");
				$saved_username = "";
				$hashed_pass = "";
				$check_user = 0;
			}
			else{
				//get row data, then remember the password for comparison
				while($row = mysqli_fetch_assoc($result)){
					$saved_username = $row['name'];
					$hashed_pass = $row['password'];
					$check_user = mysqli_num_rows($result);
				}
			}

			//If there is 1 matching user (which there should be) and the password check returns true...
		 	if($check_user == 1 && $hasher->CheckPassword($password, $hashed_pass))
		 	{
		 		//Login
		 		$_SESSION["login"] = "true";
		 		$_SESSION["username"] = $saved_username;
				header('Location: /');
			}
			else{
				spit("Login failed.");
			}

		// ------- END form processing code... -------
		}
	}
?>
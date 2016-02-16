<?php

	/*
	 *	Adonay - Could you please indent/format appropriately in future. Makes it easier to read.
	 */

	$output .= "<h1>login</h1>";

	//Login form
	$form_html = "<form action='/login' method='POST'>
			<label for='username'>Username:</label>
			<input type='text' name='username'/>
			<label for='password'>Password:</label>
			<input type='password' name='password' />
			<button type='submit'>Login</button>
				</form><p><a href='/register'>Register now.</a></p>";
	                   	
	// append form HTML to content string
	$output .= $form_html;

	// ------- START form processing code... -------

	// define variables and set to empty values
	$username = $password = "";

	//TODO Adonay/Kriss - Check to see if the user has a permission level of 1. If so, show them the admin UI.

	// check if there was a POST request
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		//create the hasher
		require("../libs/PasswordHash.php");
		$hasher = new PasswordHash(8, false);
		//CheckPassword($password, $stored_hash) this retruns true when the passwords are the same.
		//TODO Kriss/Adonay - This is going to require the script to get the password from the server, rather than just using
		//an sql statement. THEN if checkPassword() returns true, it logs in.


		// validate the form data
		if (empty($_POST["username"]) || empty($_POST["password"])) {
	   	 	//If neither field's been entered
	  	} 
		else if (!empty($_POST["username"]) && !empty($_POST["password"])){
			//If both fields have content.
			//TODO Kriss - Hash and compare the passwords before continuing.
	    	$username = $_POST["username"];
			$password = $_POST["password"];
			
			$select = "SELECT * FROM users WHERE username = '$username' && password = '$password'";
			$squery = mysqli_query($conn, $select);
			$check_user = mysqli_num_rows($squery);

			//If there is a matching user
		 	if($check_user > 0)
		 	{
		 		$_SESSION["login"] = "true";
				header('Location: /');
			}

		// ------- END form processing code... -------
		}
	}
	// output the html
	echo($output);
?>
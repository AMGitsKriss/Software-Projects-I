<?php
	$output .= "<h2>My Account</h2>";

	$output .= generateAccountPage($username, $_SESSION['admin']);

	/*
	Display username (unchangable)
	Email address, prepopulated and changable.
	User colour.
	Change password & confirm change

	If post update is set
		Are the password fields populated?
			Yes: make sure the passwords are identical then update
		Is the user an admin?
			If so, is the custom text field set?
				Yes: Update colour from that
				No: update colour from radios
		update password and email
	*/

	//Backend actions. POST data.a
	if(isset($_POST['update-account'])){
		//Update teh email field
		$email = $_POST['email'];

		//If the user is an admin, check the special field for a colour value. Otherwise, grab it from the radio-buttons.
		if($_SESSION['admin'] && isset($_POST['custom'])){
			$colour = $_POST['custom'];
		} 
		else {
			$colour = $_POST['colour'];
		}

		//If neither password field is empty
		if($_POST['password1'] != "" && $_POST['password2'] != ""){
			//And they're identical
			if($_POST['password1'] === $_POST['password2']){
				//HASH ME
				require("libs/PasswordHash.php");

				$password = $_POST['password1'];
				$hasher = new PasswordHash(8, false);
				//Minimum password length is 6
				if(strlen($_POST['password1'])>=6){
					$password = $conn->real_escape_string($password);
					//Max length is 72
					if(strlen($password) > 72){
							die("Password must be 72 characters or less.");
						}
					$password = $hasher->HashPassword($password);
				}
				//If password is too short
				else {
					die("Password must be 6 characters or more.");
				}

				$sql = "UPDATE Users SET password='$password', colour='$colour', email='$email' WHERE name='$username'";
			}
		}
		//If passwords haven't been entered..
		else {
			$sql = "UPDATE Users SET colour='$colour', email='$email' WHERE name='$username'";
		}
		$query = mysqli_query($conn, $sql);

	}
?>
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

	//Backend actions. POST data.
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

		//If passwords have been entered
		if(isset($_POST['password1'] || $_POST['password2'])){
			if($_POST['password1'] === $_POST['password2']){
				// TODO - HASH ME
				$password = $_POST['password1'];

				$sql = "UPDATE Users SET password='$password', colour='$colour', email='$email'";
			}
		}
		//If passwords haven't been entered.
		else {
			$sql = "UPDATE Users SET colour='$colour', email='$email'";
		}
	}
?>
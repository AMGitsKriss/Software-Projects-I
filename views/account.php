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
			If so, is teh custom text firld set?
				Yes: Update colour from that
				No: update colour from radios
		update password and email
	*/

	//TODO - backend actions. POST data.
?>
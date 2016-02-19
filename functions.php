<?php 

	function spit($someString){
		$someString = "<p class='devnote'>" . $someString . "</p>";
		echo $someString;
	}
	
	//Checking that email is valid.
	function validEmail($email){
		if(filter_var($email, FILTER_VALIDATE_EMAIL)){
			return true;
		} else {
			return false;
		}
	}

	function checkUsername($username){	
		//Including the global connection variable
		global $conn;
		// SQL query to fetch information of registerd users and finds user match.
		$query = mysqli_query($conn, "SELECT * FROM Users WHERE username='$username'"); 
		//Grabbing the number of rown returned from the MYSQLi_result object. 
		$rows = $query->num_rows;
		//Just in case there's no password saved.
		$storedHash = "*";
		//If there's only one user by that name, and their password hash is verified
		if($rows >= 1){
			return true;
		}
		//Returns false if there's not exactly 1 entry. 
		else return false;
	}

	function checkEmail($email){
		//Including the global connection variable
		global $conn;
		$sql = "SELECT * FROM Users WHERE email='$email'";
		//Querying to grap the email it's given.
		$query = mysqli_query($conn, $sql);
		//Grabing the quantity of entries with this address
		$rows = $query->num_rows;
		//If there's at least one entry...
		if($rows >= 1){
			return true;
		} 
		else return false;
	}

	function checkGroup($group){
		//If privacy is NOT null, then the group exists
		if(checkGroupPrivate($group) != null){
			return true;
		}
		else {
			return false;
		}
	}

	function checkGroupPrivate($group){
		global $conn;
		//Checking if that group exists already
		$sql = "SELECT private FROM Groups WHERE name='$name'";
		$query = mysqli_query($conn, $sql);
		//If so, there will be a result
		if(mysqli_num_rows($result) = 1){
			$private = $result['private'];
			if($private != 0)	return true;
			else 				return false;
		else 		return null;
		}
	}

	function addToGroup($group, $username){
		global $conn;
		//Add $username to $group via GroupMembers table
		$sql = "INSERT INTO GroupMembers (groupid, userid) VALUES ('$group', '$username')";
		$query = mysqli_query($conn, $sql);
		if(!$query){ //Unsuccessful
			echo mysqli_error($conn);
			return false;
		}
		else { //Successful
			return true;
		}
	}

	function removeFromGroup($group, $username){
		global $conn;
		//Add $username to $group via GroupMembers table
		$sql = "DELETE FROM GroupMembers WHERE groupid='$group' AND userid='$username'";
		$query = mysqli_query($conn, $sql);
		if(!$query){ //Unsuccessful
			echo mysqli_error($conn);
			return false;
		}
		else { //Successful
			return true;
		}
	}

	function getGroupOwner($group){
		global $conn;
		$sql = "SELECT owner FROM Groups WHERE name='$group'";
		$result = mysqli_query($conn, $sql);
		return $result['owner'];
	}
?>
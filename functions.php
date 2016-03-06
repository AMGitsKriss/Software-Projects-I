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
		$sql = "SELECT private FROM Groups WHERE name='$group'";
		$result = mysqli_query($conn, $sql);
		//If so, there will be a result
		$row = mysqli_fetch_assoc($result);
		if(mysqli_num_rows($result) == 1){
			$private = $row['private'];
			if($private != 0)	return true;
			else 				return false;
		}
		else 		return null;
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
		$row = mysqli_fetch_assoc($result);
		return $row['owner'];
	}

	function getEntries($name, $everything = false){
		global $conn;
		// $name - Username or Group name to get results for
		// $everything - Boolean. If true, get all the things a username is related to (their posts and group posts)
						//False by default
						//If false, only get their person items.
						//Only applies to usernames.

		//Search for posts with an owner of $name
		$sqlUserCheck = "SELECT * FROM Users WHERE userid='$name'";
		//Check how many rows there are. There should be 1. 
		//If one result, $userExists is true. Else false.

		//If results && $everything
		if($userExists && $everything){
			//Get all of the groups a user is in, and search all posts from that user, or that group.
			$sql1 = "SELECT * FROM GroupMembers where userid='$name'";
			//Put 'groupid' into list $memberOf
			//Search for each post made by the user, or ascociated with a joined group
			$sql2 = "SELECT * FROM Posts INNER JOIN GroupPosts WHERE owner='$name' OR groupid='$memberOf'";
				//Get groups that the user is a member of and search them.
		}
		else if($userExists && $everything){
		//If results && !everything
			//Get user's owned posts exclusively.
			$sql3 = "SELECT * FROM Posts WHERE owner='$name'";
		}
		else{
			//Search for posts where $name is the group.
			$sql4 = "SELECT * FROM Posts WHERE GroupPosts.groupid='$name'";
		}
	}
?>
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
		$results = [];

		//Search for posts with an owner of $name
		$sqlUserCheck = "SELECT * FROM Users WHERE name='$name'";
		$query = mysqli_query($conn, $sqlUserCheck);
		//Check how many rows there are. There should be 1. 
		//If one result, $userExists is true. Else false.
		if(mysqli_num_rows($query) == 1 && mysqli_fetch_assoc($query)['name'] == $name){
			$userExists = true;
		}
		else {
			$userExists = false;
		}

		//If results && $everything wanted
		if($userExists && $everything){
			//TODO
			//Get all of the groups a user is in, and search all posts from that user, or that group.
			$sql1 = "SELECT * FROM GroupMembers where userid='$name'";
			//Put 'groupid' into list $memberOf
			//Search for each post made by the user, or ascociated with a joined group
			$sql2 = "SELECT * FROM Posts INNER JOIN GroupPosts WHERE owner='$name' OR groupid='$memberOf'";
				//Get groups that the user is a member of and search them.
		}

		//If results && !everything
		else if($userExists && !$everything){
			//Get user's owned posts exclusively.
			$sql3 = "SELECT * FROM Posts WHERE owner='$name'";
			$query = mysqli_query($conn, $sql3);
			while($row = mysqli_fetch_assoc($query)){
				$temp = ["id" => $row['postid'], "added" => $row['added'], "name" => $row['name'], "url" => $row['url'], "owner" => $row['owner']];
				array_push($results, $temp);
			}
		}

		//Otherwise, assume $name is a group
		else{
			//TODO - Search for posts where $name is the group.
			$sql4 = "SELECT * FROM Posts WHERE GroupPosts.groupid='$name'";
		}

		return $results;
	}

	function getNavBar(){
		//build the navbar. Grey it out if not signed in.
	}

	function getPostForm(){
		global $conn;
		global $host;
		
		$username = $_SESSION['username'];

		$sql = "SELECT * from GroupMembers WHERE userid='$username'";
		$query = mysqli_query($conn, $sql);

		//Initialise "post to.." with username
		$postTo = [["U:", $username]];

		//Get the names of user's groups. Add them to the postable list.
		while($row = mysqli_fetch_assoc($query)){
			array_push($postTo, ["G:", $row['groupid']]);
		}

		//The title and link fields.
		$html = "<div class='post'>\n<form action='' method='post'>\n<p><input type='text' name='title' placeholder='Post Title (Optional)'>\n<input type='text' name='url' placeholder='Post URL'>\n";

		//Generate an option list with the post destinations.
		$html .= "<select name='postTo'>\n";
		foreach($postTo as $option){
			$html .= "<option value='$option[1]'>$option[0]$option[1] </option>\n";
		}
		$html .= "</select>\n";

		//Submit button
		$html .= "<input type='submit' name='postlink' value='Post'>\n</p>\n</form>\n</div>\n";

		return $html;
	}

	function getPageTitle($url){
		//Getting the contents of the target page
		$temp = curl_init();
		curl_setopt($temp, CURLOPT_HEADER, 0);
		curl_setopt($temp, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($temp, CURLOPT_URL, $url);
		curl_setopt($temp, CURLOPT_FOLLOWLOCATION, 1);
		$data = curl_exec($temp);
		curl_close($temp);

		//Create 
		$dom = new DOMDocument();
		//Load the page, supressing it's errors
		@$dom->loadHTML($data);
		//Get title tags.
		$title = $dom->getElementsByTagName('title');
		//Strip the title data from the object.
		$title = $title->item(0)->nodeValue;
		return $title;
	}
?>
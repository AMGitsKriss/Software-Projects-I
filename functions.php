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
			echo $username.mysqli_error($conn);
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

	function getGroupMember($username, $group){
		global $conn;
		$sql = "SELECT userid FROM GroupMembers WHERE groupid='$group' AND userid='$username'";
		$result = mysqli_query($conn, $sql);
		//If there is one row, return true
		if(mysqli_num_rows($result) == 1){
			return true;
		}
		return false;
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
			//Get all of the groups a user is in, and search all posts from that user, or that group.
			$sql2 = "SELECT DISTINCT * FROM Posts INNER JOIN Users WHERE posts.owner=users.name AND (owner='$name' OR postid IN (SELECT postid FROM GroupPosts WHERE groupid IN (SELECT groupid FROM GroupMembers WHERE userid='$name'))) ORDER BY postid DESC";
			$query = mysqli_query($conn, $sql2);
			spit(mysqli_error($conn));
			while($row = mysqli_fetch_assoc($query)){
				$temp = ["postid" => $row['postid'], "added" => $row['added'], "postname" => $row['postname'], "url" => $row['url'], "owner" => $row['owner'], "colour" => $row['colour']];
				array_push($results, $temp);
			}
				//Get groups that the user is a member of and search them.
		}

		//If results && !everything
		else if($userExists && !$everything){
			//Get user's owned posts exclusively.
			$sql3 = "SELECT * FROM Posts INNER JOIN Users WHERE posts.owner=users.name AND owner='$name' ORDER BY postid DESC";
			$query = mysqli_query($conn, $sql3);
			while($row = mysqli_fetch_assoc($query)){
				$temp = ["postid" => $row['postid'], "added" => $row['added'], "postname" => $row['postname'], "url" => $row['url'], "owner" => $row['owner'], "colour" => $row['colour']];
				array_push($results, $temp);
			}
		}

		//Otherwise, assume $name is a group
		else{
			//Search for posts by id in Posts table. where $name is the group.
			$sql4 = "SELECT * FROM Posts INNER JOIN Users WHERE posts.owner=users.name AND postid IN (SELECT postid FROM GroupPosts WHERE GroupPosts.groupid='$name') ORDER BY postid DESC";
			$query = mysqli_query($conn, $sql4);
			while($row = mysqli_fetch_assoc($query)){
				$temp = ["postid" => $row['postid'], "added" => $row['added'], "postname" => $row['postname'], "url" => $row['url'], "owner" => $row['owner'], "colour" => $row['colour']];
				array_push($results, $temp);
			}
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
		$html .= "<span class='option-container'><select name='postTo'>\n";
		foreach($postTo as $option){
			$html .= "<option value='$option[1]'>$option[0]$option[1] </option>\n";
		}
		$html .= "</select></span>\n";

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

	function encaseResults($plainResults, $editable = false){
		//post container tag
		$results = "<div class=post-container>\n";

		//Do we want an edit button on these posts?
		$editLink = "";
		if($editable == true){
			$editLink = "<div class=edit><a onClick='editEntryForm(\"post".$row['postid']."\")' href='javascript:void(0);'>[Edit]</a></div>";
		}
		foreach($plainResults as $row){
			//plainResults: $row['postid'] | $row['added'] | $row['name'] | $row['url'] | $row['owner']
			//Formatting the information in plainResults.
			//TODO make sure entryEditForm("postID") is properly excaped. 
			$results .= "<div class=entry-container id=post".$row['postid']." style='background-color:".$row['colour']."'><div class=post-main><a href='".$row['url']."'>".$row['postname']."</a></div><div class=owner>".$row['owner']."</div><div class=date-posted>".$row['added']."</div>$editLink</div>\n";
			//TODO - Add editing form
		}
		$results .= "</div>\n";
		return $results;
	}

	function generateColourForm($userCol, $admin = false){ //Takes isset-session-admin. If not given, is false.
		//List of allowed colours
		$colChoice = ["LightSteelBlue", "PaleGoldenRod", "CadetBlue", "LightGrey", "Salmon", "SandyBrown", "Gold", 
						"GreenYellow", "Pink", "Khaki", "PaleVioletRed", "LightBlue", "Orange", "Tomato", "Wheat", "YellowGreen"];
		
		$select = "<div class=colourselect>\n";
		
		//checked='checked'

		//Populating a form of colours
		foreach($colChoice as $col){
			if($col == $userCol){
				$select .= "<p style='background-color:$col'><label><input type='radio' name='colour' checked='checked' value='$col'>$col</label></p>\n";
			}
			else{
				$select .= "<p style='background-color:$col'><label><input type='radio' name='colour' value='$col'>$col</label></p>\n";
			}
		}
		if($admin){
			//Add a text box for custom colour codes.
			$select .= "<label>Custom Colour: (This overrides the above radio-buttons)</label><input type='text' name='custom' placeholder='#FFFFFF'>\n";
		}
		$select .= "</div>\n";
		return $select;
	}

	function generateAccountPage($username, $admin = false){
		global $conn;

		//Get teh user's information to present
		$sql = "SELECT * FROM Users WHERE name='$username'";
		$results = mysqli_query($conn, $sql);
		$userDetails = mysqli_fetch_assoc($results);

		//Present the account
		$select = "<form method='post' action='var_host/account'>\n<label>Username:</label><p>$userDetails[name]</p>\n";

		//prepopulated email address field.
		$select .="<label>Email Address:</label><p><input type='text' name='email' value='$userDetails[email]'></p>";

		//Update Password
		$select .="<label>Update Password:</label>\n<p><input type='password' name='password1'></p>\n<p><input type='password' name='password2'></p>";

		//Colour select
		$select .= generateColourForm($userDetails['colour'], $admin);

		$select .= "<input type='submit' value='Update Account' name='update-account'>\n</form>\n";

		return $select;
	}

	function generateHeader($pageTitle, $loggedIn){
		//Header HTML, along with the navigation HTML
		//JQuery included (1.12.3)
		$header = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>\n<html xmlns='http://www.w3.org/1999/xhtml'>\n<head>\n<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />\n<title>Operam - $pageTitle</title>\n<link rel='stylesheet' type='text/css' href='css/default.css'>\n  <script src='https://code.jquery.com/jquery-1.12.3.js'></script>\n<script src='javascript.js'></script>\n</head>\n<body>";
		
		//TODO - Call the navigation function here
		if ($loggedIn){
			$header .= file_get_contents('templates/navigation.html');
		}
		else {
			$header .= file_get_contents('templates/navigation-signed-out.html');
		}
		//TODO - Will this work without handing the fucntion the session?
		if(isset($_SESSION['admin'])){
			//$header .= file_get_contents('templates/adminNavigation.html');
		}
		return $header;
	}
?>
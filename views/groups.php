<?php

	$output .= "<h2>Groups</h2>";

	/*
	 *	If the ?group=THING query is defined, we're going to save that variable.
	 *	If a user action is also defined, we'll do that. If it's just the group
	 *	name, we'll list check that the user is a member of that group, then get
	 *	all it's posts.
	 */

	//Join group dialogue
	$output .= file_get_contents("templates/join-group.html");

	//New group dialogue.
	$output .= file_get_contents("templates/new-group.html");

	if(isset($_POST['create-group'])){
		$new_group = mysqli_real_escape_string($conn, $_POST['new-group']);
		//If the group doesn't exist yet...
		if(!checkGroup($new_group)){
			$private = isset($_POST['private']);
			//If $private is 1 (true) leave it as 1, else set to 0 (false).
			$private = ($private == 1) ? 1 : 0;
			//spit($private);
			$username = $_SESSION['username'];
			$sql = "INSERT INTO Groups (name, private, owner) VALUES ('$new_group', '$private', '$username')";
			$result = mysqli_query($conn, $sql);
			if($result){
				//spit("A");
				addtoGroup($new_group, $username);
				$output .= "<p>Group created successfully.</p>";
			}
			else {
				//spit("B");
				$output .= "<p>" . mysqli_error($conn) . "</p>";
			}
		}
		//Otherwise, refuse to make a new group.
		else {
			$output .= "<p>That group name already exists. Please choose another.</p>";
		}
	}
	else if(isset($_POST['join-group'])){
		$join_group = mysqli_real_escape_string($conn, $_POST['new-group']);
		//spit($join_group);
		//If the group ISN'T private...
		if(checkGroupPrivate($join_group) == FALSE){
			addtoGroup($join_group, $username);
			$output .= "<p>Group joined successfully.</p>";
		}
		//If the group IS private
		else if(checkGroupPrivate($join_group) == TRUE){
			$output .= "<p>That group is private. You must be invited.</p>";
		}	
		else {
			$output .= "<p>That group doens't exist.</p>";
		}
	}

	//If the user has clicked the leave group option.
	if(isset($_POST['leave-group'])){
		//Owner tries to leave.
		if($_SESSION['username'] == getGroupOwner($group) && isset($_POST['new-owner'])){
			//Change the owner
			$new_owner = $_POST['new-owner'];
			$username = $_SESSION['username'];
			$sql = "UPDATE Groups SET owner='$new_owner' WHERE owner='$username'";
			mysqli_query($conn, $sql);
			//Leave the group.
			$sql = "DELETE FROM GroupMembers WHERE userid='$username' AND groupid='$group'";
			mysqli_query($conn, $sql);
		}
		//User tried to leave
		else if($_SESSION['username'] != getGroupOwner($group)){
			//Just leave the group
			$sql = "DELETE FROM GroupMembers WHERE userid='$username' AND groupid='$group'";
			mysqli_query($conn, $sql);
		}
		//Fail
		else{
			//spit("Error: Could not remove " . $_SESSION['username'] . "From the group " . $group . ".");
		}
	}

	if(isset($_GET['group'])){
		$group = $_GET['group']; 
		//If submitted by group owner
		if($_SESSION['username'] == getGroupOwner($group)){
			//Add a user
			if(isset($_GET['add'])){
				$user_to_add = mysqli_real_escape_string($_GET['add']); 
				addToGroup($group, $user_to_add);
			}
			//Remove a user
			else if(isset($_GET['remove'])){
				$user_to_remove = mysqli_real_escape_string($_GET['remove']); 
				removeFromGroup($group, $user_to_remove);
			}
			//If group is private, add the "add/remove" user dialogue here.
			if(checkGroupPrivate($group)){
				$output .= file_get_contents("templates/add-remove-users.html");
			}
			$output .= "<form name='leave-group' method'post' action'var_host/groups'><label>Set new group admin:</label><input type='text' name='new-owner'><input type='submit' text='Leave Group'></form>";
		}
		//If a gorup member, show dialogue
		else if(getGroupMember($username, $group)){
			//Everyone else then sees...
			$output .= "<form name='leave-group' method'post' action'var_host/groups'><input type='submit' text='Leave Group'></form>";
		}

		//Group is private?
		if(checkGroupPrivate($group) && $_SESSION['admin'] == false){
			header("Location: $host/403");
			//No permission to view this
		}
		else {
			//Getting, prettifying and printing entries WITHOUT edit functionality. User currently must do that via landing page.
			$output .= encaseResults(getEntries($group, true));
		}

	}
	else{
		//TODO - List all of the groups the user is a member of.
		if($_SESSION['admin']){
			//spit("Admin List");
			//Get ALL groups
			$sql = "SELECT DISTINCT owner, groupid FROM Groups INNER JOIN GroupMembers";
		}
		else {
			//spit("Normal List");
			//Searched based on usename
			$sql = "SELECT DISTINCT * FROM GroupMembers INNER JOIN Groups WHERE userid='$username' AND groupid=name";
			//Select everything from groups where userid in GroupMember is paired with that groupid.
		}
		$result = mysqli_query($conn, $sql);
		if($result === FALSE){
			//Oops
			//spit( mysqli_error($conn) );
		}
		else {
			while($row = mysqli_fetch_assoc($result)){
				//Creating the table entries for each group
				$temp = $row['groupid'];
				$output .= "<p><a href='var_host/groups?group=" . $temp . "'>" . $temp . " | Owner: " . $row['owner'] . "</a></p>";
			}
		}
	}
?>
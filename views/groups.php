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
		$new_group = mysqli_real_escape_string($_POST['new-group']);
		//If the group doesn't exist yet...
		if(!checkGroup($new_group)){
			$private = isset($_POST['private']);
			$username = $_SESSION['username'];
			$sql = "INSERT INTO Groups (name, private, owner) VALUES ('$new_group', '$private', '$username')";
			$result = mysqli_query($conn, $sql);
			if($result){
				addtoGroup($new_group, $username);
				$output .= "<p>Group created successfully.</p>";
			}
			else {
				$output .= "<p>" . mysqli_error($conn) . "</p>";
			}
		}
		//Otherwise, refuse to make a new group.
		else {
			$output .= "<p>That group name already exists. Please choose another.</p>";
		}
	}
	else if(isset($_POST['join-group'])){
		$join_group = mysqli_real_escape_string($_POST['new-group']);
		//If the group ISN'T private...
		if(checkGroupPrivate($new_group) == FALSE){
			addtoGroup($new_group, $username);
			$output .= "<p>Group joined successfully.</p>";
		}
		//If the group IS private
		else if(checkGroupPrivate($new_group) == TRUE){
			$output .= "<p>That group is private. You must be invited.</p>";
		}	
		else {
			$output .= "<p>That group doens't exist.</p>";
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
				//TODO - what if the owner removes themselves?
			}
			//If group is private, add the "add/remove" user dialogue here.
			if(checkGroupPrivate($group)){
				$output .= file_get_contents("templates/add-remove-users.html");
			}
		}
		//Everyone then sees...
		//TODO - add a "leave" user dialogue here.			
		//TODO - List all of the group's posts
	}
	else{
		//TODO - List all of the groups the user is a member of.
		if($_SESSION['admin']){
			//Get ALL groups
		}
		else {
			//Searched based on usename
		}
	}
?>
<?php

	$output .= "<h2>Home</h2>\n<p>Welcome.</p>\n";

	$output .= getPostForm();

	//User has posted a link
	if(isset($_POST['postlink'])){
		spit("getlink is set");

		$url = $_POST['url'];
		$title = $_POST['title'];
		$postTo = $_POST['postTo'];

		//If the  url diens't start with http or https, add it
		if(!(substr( $url, 0, 7 ) === "http://" || substr( $url, 0, 8 ) === "https://")){
			$url = "http://" . $url;
		}

		//If title is user defined, i.e. not an empty string, use that. Otherwise, get it from the site. 
		if($title != ""){
			$title = mysqli_real_escape_string($conn, $_POST['title']);
		}
		else{
			//Get the title, escape it, then crop it to 100 characters.
			$title = substr(mysqli_real_escape_string($conn, getPageTitle($url)), 0, 100);
		}
		//Stuff needs inserts here

		$url = mysqli_real_escape_string($conn, $url);
		$ip = $_SERVER['REMOTE_ADDR'];

		$sql = "INSERT INTO Posts (postname, url, owner, ip) VALUES ('$title', '$url', '$username', '$ip')";

		$query = mysqli_query($conn, $sql);
		echo mysqli_error($conn);

		//If this is NOT a username post... i.e a group post
		if($postTo != $username){
			//Get the id of what we just posted...
			$postid = mysqli_insert_id($conn);
			$sql = "INSERT INTO GroupPosts (groupid, postid) VALUES ('$postTo', '$postid')";
			$query = mysqli_query($conn, $sql);
			echo mysqli_error($conn);
		}
	}

	//User edited link
	if(isset($_POST['update'])){

		$id = $_POST['id'];
		$title =  mysqli_real_escape_string($conn, $_POST['title']);
		$url =  mysqli_real_escape_string($conn, $_POST['url']);
		$group = $_POST['postTo'];
		//Update post with corresponding id. 
		$sql = "UPDATE posts SET postname='$title', url='$url' WHERE postid='$id'";
		$query = mysqli_query($conn, $sql);
		echo mysqli_error($conn);

		//To update the group, we want to delete anything with this id from the relationship table
		//then IF it's not being posted to the user, insert a new relationship into the table.

		//Thus, delete relationships first
		$sql = "DELETE FROM groupposts WHERE postid='$id'";
		$query = mysqli_query($conn, $sql);
		echo mysqli_error($conn);
		if($group != $username){
			//Then add to the relationship table 
			$sql = "INSERT INTO groupposts (postid, groupid) VALUES ('$id', '$group')";
			$query = mysqli_query($conn, $sql);
			echo mysqli_error($conn);
		}		
	}

	//User deleted link
	if(isset($_POST['delete'])){
		
		$id = $_POST['id'];
		$title =  mysqli_real_escape_string($conn, $_POST['title']);
		$url =  mysqli_real_escape_string($conn, $_POST['url']);
		$group = $_POST['postTo'];

		//delete post with corresponding id
		$sql = "DELETE FROM posts WHERE postid='$id'";
		$query = mysqli_query($conn, $sql);
		echo mysqli_error($conn);


		//Then skim through the group/post relationship table to delete any references to that id
		$sql = "DELETE FROM groupposts WHERE postid='$id'";
		$query = mysqli_query($conn, $sql);
		echo mysqli_error($conn);
	}

	//Printing entries, WITH edit buttons on landing page.
	$output .= encaseResults(getEntries($username, true), true);

?>
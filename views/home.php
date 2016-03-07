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
		//TODO - Stuff needs inserting into posts here

		$url = mysqli_real_escape_string($conn, $url);
		$ip = $_SERVER['REMOTE_ADDR'];

		$sql = "INSERT INTO Posts (name, url, owner, ip) VALUES ('$title', '$url', '$username', '$ip')";

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

	//Printing entries
	$temp = getEntries($username, true);
	foreach($temp as $row){
		//TODO - Build a function to format this properly.
		$output .= "<p>" . $row['name'] . " : " . $row['url'] . "</p>";
	}

?>
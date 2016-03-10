<?php 
	error_reporting(E_ALL);
	ini_set('display_errors', true);
	
	require("functions.php");
	require("config/db_connect.php");

	session_start();

	//Declare this now
	$output = "";
//-----------------------------------------------
	//TODO - I have no idea what's going on here. 
	// If no page, go to home page, then if they're logged in include navigation? Then if not logged in go to login.php?


	if (!isset($_GET['page'])) 
	{
	    $page_id = 'home'; 
	} else {
	    $page_id = $_GET['page'];
	}

	//These $tempOutput enties need to come AFTER the switch statement. 
	//Should return a interactive version of navigation when handed false. 
	//Possible 2D array for navigation structure - Means changes only have to be made in one place.


	//If not logged in
	if(!isset($_SESSION['login'])){
		//Send them straight to the login/register screen
		$page_id = 'login';
	}

	//We'll be using this a lot
	$username = $_SESSION['username'];

//-----------------------------------------------

	spit("Going to: ".$page_id);
	switch ($page_id) {
	case 'home' :
		$output .= generateHeader("Landing Page", $_SESSION["login"]);
		include 'views/home.php';
		break;
	case 'login':
		//Contains both the login and registration content
		$output .= generateHeader("Sign in", $_SESSION["login"]);
		include 'views/login.php';
		break;
	case 'logout' :
		//include 'views/logout.php';
		session_destroy();
		header('location: ' . $host);
		break;
	case 'groups' :
		$output .= generateHeader("Your Groups", $_SESSION["login"]);
		include 'views/groups.php';
		break;
	case 'account' :
		$output .= generateHeader("Your Account", $_SESSION["login"]);
		include 'views/account.php';
		break;
	default :
		$output .= generateHeader("Page Not Found", $_SESSION["login"]);
		include 'views/404.php';
		break;
	}


	mysqli_close($conn);
	
	//Add footer to the page
	$output .= file_get_contents("templates/footer.html"); //closing html tags
	
	//Every time 'var_host' appears in the html, it's replaces with $host.
	//Allows for more elegant navigation.
	$output = str_replace("var_host", $host, $output);
	echo $output;
?>
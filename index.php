<?php 
	error_reporting(E_ALL);
	ini_set('display_errors', true);
	
	require("functions.php");
	require("config/db_connect.php");

	include("templates/header.html");

	spit("This is a Spit()");

//-----------------------------------------------
	//TODO - I have no idea what's going on here. 
	// If no page, go to home page, then if they're logged in include navigation? Then if not logged in go to login.php?


	if (!isset($_GET['page'])) 
	{
	    $page_id = 'home'; 
	} else {
	    $page_id = $_GET['page'];
	}

	if (isset($_SESSION['login']) && $_SESSION["login"]=='true')
	{
		include('templates/navigation.html');
	}

	if(isset($_SESSION['admin']))
	{
	include('templates/adminNavigation.html');
	}
	//If not logged in
	if(!isset($_SESSION['login'])){
		//Stuff that anyone can do while signed out
		if($page_id == "register"){
			//Do nothing, they can continue there
		}
		else{
			//Otherwise send them to the login screen.
			$page_id = 'login';
		}
	}


//-----------------------------------------------

	spit("Going to: ".$page_id);
	switch ($page_id) {
	case 'home' :
	    include 'views/home.php';
	    break;
	case 'register':
		//TODO Kriss - Fix this. The form can go into the php file
		include 'templates/register.html';
		break;
	case 'login':
		include 'views/login.php';
		break;
	case 'log-out' :
	 include 'views/logout.php';
	    break;
	default :
		//TODO - Should this be 404? Would it make more sense to
		//redirect the user to the root "/" directory? Thus getting rid of any place.com/whatever url?
	    include 'views/404.php';
	}


	mysqli_close($conn);
	include("templates/footer.html"); //closing html tags
?>
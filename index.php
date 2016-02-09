<?php 
	error_reporting(E_ALL);
	ini_set('display_errors', true);
	
	require("functions.php");
	require("config/db_connect.php");
	include("templates/register.html");
	include('templates/navigation.html');
	
if (!isset($_GET['page'])) {
    $page_id = 'home'; // display home page
} else {
    $page_id = $_GET['page']; // else requested page
}

switch ($page_id) {
case 'logIn' :
	include 'logIn.php';
	break;
default :
	include 'views/404.php';
}


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

if(!isset($_SESSION['login']))
{
	include('views/login.php');
	include('templates/signUpNavigation.html');
}


switch ($page_id) {
case 'home' :
    include 'views/home.php';
    break;
case 'log-out' :
 include 'views/logout.php';
    break;
default :
    include 'views/404.php';
}


mysqli_close($link);

?>
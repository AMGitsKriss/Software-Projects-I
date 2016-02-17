<?php 

//TODO - The views i nhere need adding to the main index page.
error_reporting(E_ALL);
ini_set('display_errors', true);

require("functions.php");
require("config/db_connect.php");
include("templates/register.html");
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

if (isset($_SESSION['admin']))
{
  include('templates/adminNavigation.html');
}

if (!isset($_SESSION['login']))
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
case 'groups':
  include 'views/groups.php'
  break;
case 'settings':
  include 'views/settings.php'
  break;
default :
  include 'views/404.php';
}
mysqli_close($link);

<?php

require('includes/db_connect.php');
include('templates/design.css');
$content = "<h1>login</h1>";

// define a variable with path to the script which will process form
// ->	$_SERVER["PHP_SELF"] is a path to the current script (index.php)


// fetch the artists so that we have access to their names and IDs
$sql = "SELECT username, password FROM customer";

$result = mysqli_query($link, $sql);

// check query returned a result
if ($result === false) {
    echo mysqli_error($link);
} 
else
 {


// define the form HTML (would ideally be in a template)
$form_html = "<form action='".$action."' method='POST'>
		<fieldset>
		    <label for='username'>username:</label>
		    <input type='text' name='username'/>
		</fieldset>
                <fieldset>
                    <label for='password'>password:</label>
                    <input type='password' name='password' />
                </fieldset>
                <button type='submit'>LogIn</button>
              </form>";
                  
              	
// append form HTML to content string
$content .= $form_html;

// ------- START form processing code... -------

function clean_input($data) {
  $data = trim($data); // strips unnecessary characters from beginning/end
  $data = stripslashes($data); // remove backslashes
  $data = htmlspecialchars($data); // replace special characters with HTML entities
  return $data;
}

// define variables and set to empty values
$username =$password = "";

// check if there was a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// validate the form data
	if (empty($_POST["username"])) 
	{
   	 	$username = "username is required";
  	} 
	else 
	{
    		$username = $_POST["username"];
  	}
	
	if (empty($_POST["password"])) 
	{
   	 	$password = "password is required";
  	} 
	else 
	{
    		$password = $_POST["password"];
	}
	
	
	$select = "SELECT * FROM customer WHERE username = '$username' && password = '$password'";
	$squery = mysqli_query($link, $select);
	$check_user = mysqli_num_rows($squery);

 	if($check_user > 0)
 	{
 		$_SESSION["login"] = "true";
		 header('Location: index.php');
	}
	else 
	{
		echo mysqli_error($link);
		echo ("wrong username or password");
	}
	
	$select2 = "SELECT * FROM adminLogin WHERE username = '$username' && password = '$password'";
	$squery2 = mysqli_query($link, $select2);
	$check_user2 = mysqli_num_rows($squery2);

 	if($check_user2 > 0)
 	{
 		$_SESSION["login"] = "true";
		$_SESSION["admin"] = "true";
		 header('Location: index.php');
	}
	else 
	{
		echo mysqli_error($link);
		echo ("wrong username or password");
	}


}



// ------- END form processing code... -------
// output the html
echo($content);
}
?>
<?php
	
	
//define a variable with path to the script which will process form
// ->	$_SERVER["PHP_SELF"] is a path to the current script (index.php)
$action = $_SERVER["PHP_SELF"]."?page=search";

// define the form HTML (would ideally be in a template)
   $form_html = "<form method=\"post\" action=\"\">
    <label for='usersearch'>Find user</label><br />
    <input type='text' id='search' name='search' /><br />
    <input type='submit' name='submit' value='Search' />
  </form>";            
              	
// append form HTML to output string
$output .= $form_html;

$output .= "<h2>Friends</h2>";

// ------- START form processing code... -------

// define variables and set to empty values
$source =$title = "";

// check if there was a POST request

if (isset($_POST['submit'])) {
	
	//if((!isset($_POST["search"]))){
	// validate the form data
	$search = $_POST["search"];
	$user_search  = trim($search);
	$user_search  = stripslashes($user_search);
	$user_search  = htmlspecialchars($user_search);
	$clean_search = str_replace(',',' ',$user_search);
	
	
	// fetch the artists so that we have access to their names and IDs
		

$sql = "SELECT name FROM users WHERE name like '%$clean_search%'";

$result = mysqli_query($conn, $sql);
			
	if ($result === false) {
	    echo mysqli_error($conn);
	} else {
	    $output .= "<table border='1'>";
	    
	    $output .= "<tbody>";
	    // fetch associative array
	    while ($row = mysqli_fetch_assoc($result)) {
			$temp = $row['name'];
		if($temp==$search){
		$output .= "<tr>";
		//$output .= "<td>".$row['name']."</td>";
		$output .= "</tr>";
		$form_html = "<form method=\"post\" action=\"\">
		<input type='submit' value='$row[name]' name='add' />
		</form>";
		$output .= $form_html ;
	    }}
	    $output .= "</tbody></table>";
	    // free result set
	    mysqli_free_result($result);
	
	}
	
	}
	if(isset($_POST['add'])){
		
		
		
		
		
		
		
		
		
		$friendduplicate=false;
		$sql = "SELECT friend FROM friends WHERE user = '$_SESSION[username]'";

$result = mysqli_query($conn, $sql);
			
	if ($result === false) {
	    echo mysqli_error($conn);
	} else {
	    $output .= "<table border='1'>";
	    
	    $output .= "<tbody>";
	    // fetch associative array
	    while ($row = mysqli_fetch_assoc($result)) {
			$temp = $row['friend'];
		if($temp==$_POST['add']){
		$friendduplicate=true;
	}}}
		
		
		
		
		
		
		
		
		
		
		
		
		if($friendduplicate===false){
		$query = "INSERT INTO friends (user, friend) values ('$_SESSION[username]', '$_POST[add]')";
		
		$result = mysqli_query($conn, $query);
		}
	}
	
	$sql2 = "SELECT friend FROM friends WHERE user ='$_SESSION[username]'";

$result2 = mysqli_query($conn, $sql2);
			
	if ($result2 === false) {
	    echo mysqli_error($conn);
	} else {
	    $output .= "<table class='table table-striped' border='1'>";
	    $output .= "<thead><tr><th>Friends</th><th>profile picture</th></tr></thead>";
	    $output .= "<tbody>";
	    // fetch associative array

	    while ($row = mysqli_fetch_assoc($result2)) {
			$output .= "<tr>";
		$output .= "<td>".$row['friend']."</td>";
		
		$sql3 = "SELECT img FROM users WHERE name ='$row[friend]'";
		$result3 = mysqli_query($conn, $sql3);
		if ($result3 === false) {
	    echo mysqli_error($conn);
	} else {
		 while ($row = mysqli_fetch_assoc($result3)) {
			 if($row['img']===""){
				 $output .= "<td><img src='uploads/noprofile.gif' style='height: 100px;' /></td>";}
			 else{
			 $output .= "<td><img src='".$row['img']."' style='height: 100px;' /></td>";}
		 }
	}
		
		
		$output .= "</tr>";
		$form_html = "<form method=\"post\" action=\"\">
		
		</form>";
		$output .= $form_html ;
	    }
	    $output .= "</tbody></table>";
	    // free result set
	    mysqli_free_result($result2);
	
	}
	
	
	
	
		//		$query = "INSERT INTO friends (user, friend) values ('$_SESSION[username]', ASD 1234)";
		
		
	//	$result = mysqli_query($conn, $query);	

// ------- END form processing code... -------
// output the html
	
?>

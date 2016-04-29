<?php
	$output .= "<h2>My Account</h2>";

	$output .= generateAccountPage($username, $_SESSION['admin']);

	/*
	Display username (unchangable)
	Email address, prepopulated and changable.
	User colour.
	Change password & confirm change

	If post update is set
		Are the password fields populated?
			Yes: make sure the passwords are identical then update
		Is the user an admin?
			If so, is the custom text field set?
				Yes: Update colour from that
				No: update colour from radios
		update password and email
	*/

	//Backend actions. POST data.a
	if(isset($_POST['update-account'])){
		
		$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    $imgexists=1;
	$imgcheck = true;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 50000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
	$imgcheck = false;
}

//$target_file = $target_dir .The file ". basename( $_FILES["fileToUpload"]["name"]);
//echo "".$target_dir .The file ". basename( $_FILES["fileToUpload"]["name"])."";

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
	$imgcheck = false;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
	$imgcheck = false;
// if everything is ok, try to upload file
} else {
	if($imgexists===1){}else{
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		$imgcheck=true;
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }}
}
		$emailcheck = true;
		//Update teh email field
		$email = $_POST['email'];
		if(!validEmail($email)){
			$emailcheck=false;
		}
		$colourcheck = false;
		//If the user is an admin, check the special field for a colour value. Otherwise, grab it from the radio-buttons.
		if($_SESSION['admin'] && $_POST['custom'] != ""){
			$colour = $_POST['custom'];
		} 
		else {
			if(isset($_POST['colour']))
			{
				$colour = $_POST['colour'];
				$colourcheck = true;
			}
			
		}

		//If neither password field is empty
		if($_POST['password1'] != "" && $_POST['password2'] != ""){
			//And they're identical
			if($_POST['password1'] === $_POST['password2']){
				//HASH ME
				require("libs/PasswordHash.php");

				$password = $_POST['password1'];
				$hasher = new PasswordHash(8, false);
				//Minimum password length is 6
				if(strlen($_POST['password1'])>=6){
					$password = $conn->real_escape_string($password);
					//Max length is 72
					if(strlen($password) > 72){
							die("Password must be 72 characters or less.");
						}
					$password = $hasher->HashPassword($password);
				}
				//If password is too short
				else {
					die("Password must be 6 characters or more.");
				}
				if($imgcheck===true)
				{
					if($emailcheck===true)
					{
						if($colourcheck===true)
						{
								$sql = "UPDATE Users SET password='$password', colour='$colour', email='$email', img='$target_file' WHERE name='$username'";
						}
						else{
							$sql = "UPDATE Users SET password='$password', email='$email', img='$target_file' WHERE name='$username'";
						}
						
					}else
					{
						if($colourcheck===true)
						{
							$sql = "UPDATE Users SET password='$password', colour='$colour', img='$target_file' WHERE name='$username'";
						}
						else{
							$sql = "UPDATE Users SET password='$password', img='$target_file' WHERE name='$username'";
						}
						
					}
					
				}else
				{	
					if($emailcheck===true)
					{
						$sql = "UPDATE Users SET password='$password', colour='$colour', email='$email' WHERE name='$username'";
					}else
					{
						$sql = "UPDATE Users SET password='$password', colour='$colour' WHERE name='$username'";
					}
					
				}
			}
		}
		//If passwords haven't been entered..
		else {
			if($imgcheck===true)
			{
				$sql = "UPDATE Users SET colour='$colour', email='$email', img='$target_file' WHERE name='$username'";	
			}else{
				$sql = "UPDATE Users SET colour='$colour', email='$email' WHERE name='$username'";
			}
			
		}
		$query = mysqli_query($conn, $sql);

	}
?>
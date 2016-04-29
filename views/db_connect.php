<?php

$host = "http://qvvz.uk/soft";
if(strpos($_SERVER['REMOTE_ADDR'], "fe80::94f6:3b70:fef7:84ca") !== False){ //If Kriss's desktop
	$host = "http://orion/soft"; 	//Set the host to the home server
}

$conn = mysqli_connect(
	"localhost", //server
	"root", //username 
	"findME156442", //password
	"software" //database name
);

if(mysqli_connect_errno()){
	exit(mysqli_connect_error());
}


?>
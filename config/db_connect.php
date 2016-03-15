<?php

$host = "http://qvvz.uk/soft";
if(strpos($_SERVER['REMOTE_ADDR'], "fe80::94f6:3b70:fef7:84ca") !== False){
	$host = "http://orion/soft";
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
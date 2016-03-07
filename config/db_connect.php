<?php

$host = "http://orion/soft";

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
<?php

$host = "http://k-jessop.co.uk/soft";

$conn = mysqli_connect(
	"orion", //server
	"root", //username 
	"f7a7f0658a", //password
	"software" //database name
);

if(mysqli_connect_errno()){
	exit(mysqli_connect_error());
}


?>
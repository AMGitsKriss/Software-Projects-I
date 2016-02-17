<?php

$host = "http://k-jessop.co.uk/soft";

$conn = mysqli_connect(
	"qvvz.uk", //server
	"software", //username 
	"projects", //password
	"software" //database name
);

if(mysqli_connect_errno()){
	exit(mysqli_connect_error());
}


?>
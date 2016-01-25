<?php

$conn = mysqli_connect(
	"localhost", //server
	"username", //username 
	"password", //password
	"db_name" //database name
);

if(mysqli_connect_errno()){
	exit(mysqli_connect_error());
}


?>
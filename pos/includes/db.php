<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'restpos';

$connection = mysqli_connect('localhost', 'root', '', 'restpos');
$max_filesize = 41943040;
if($connection){
	// echo "connected";
}
// Checking the connection
if (mysqli_connect_errno()) {
	die('Database connection failed ' . mysqli_connect_error());
}
 
?>
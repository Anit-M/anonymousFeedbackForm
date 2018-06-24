<?php
$servername="localhost";
$username="root";
$password="";
$dbname="feedback";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if(! $conn){
	die("Server Error".mysql_connect_error());
}

?>
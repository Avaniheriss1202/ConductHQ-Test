<?php

$mysqli = new mysqli("localhost","root","","conductlogicdb");

/* Check Connection */

if (mysqli_connect_errno()){

	printf("Connect Fail: %s\n", mysqli_connect_error());
	exit();
}

/* Return name of the current database */

if($result = $mysqli->query("Select Database()")){
	$row = $result->fetch_row();
	printf("Default Database is: %s. \n",$row[0]);
	$result->close();


}

?>
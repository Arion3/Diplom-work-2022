<?php
$mysqli = mysqli_connect('127.0.0.1', 'root','','avtovaz');
if ($mysqli->connect_error)
{
	die('Connect Error ('.$mysqli->connect_error.')'. $mysqli->connect_error);
}
?> 
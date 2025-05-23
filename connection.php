<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

$hostname = 'localhost';
$username = 'root';
$password = 'root'; // Replace 'your_password' with the actual password
$database = 'mimma_db';

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

$conn = mysqli_connect('localhost','root','root','mimma_db')or die('connection failed');

?>

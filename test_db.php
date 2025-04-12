<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('memory_limit', '512M');
$servername="localhost";
$username="if0_38727546";
$password="Joy11082004";
$database="if0_38727546_agrisphere";
//create connection
$conn=mysqli_connect($servername,$username,$password);
$database="agrisphere";
//check connection
if(!$conn){
    die("Connection failed: ".mysqli_connect_error());
}
//echo "Connected successfully";

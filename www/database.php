<?php
$username = "root";
$password = "";
$host = "localhost";
$port = "3306";
$database = "joevet";

$db = new mysqli($host, $username, $password, $database, $port);
if($db->connect_error){
    die("Connect Failed" . $db->connect_error);
}
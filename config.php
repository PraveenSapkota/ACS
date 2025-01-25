<?php
$server = "localhost";
$database = "registration"; //My database name in phpMyAdmin
$user = "root";
$password = "";

// Create a connection
$connect = new mysqli($server, $user, $password, $database);

// Check the connection
if ($connect->connect_error) {
    die("Connection Failed: " . $connect->connect_error);
} else {
    
    // echo "Connected successfully";
}
?>

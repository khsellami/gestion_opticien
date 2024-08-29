<?php
// Database configuration
$host = 'localhost';        // Database host, usually 'localhost'
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password
$database = 'opticien'; // Replace with your database name

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// If successful, you can proceed with further operations
// echo "Connected successfully"; // For testing purposes, uncomment to see if the connection works
?>

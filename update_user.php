<?php
// Database credentials
$servername = "localhost"; // or your database server address
$username = "root"; // replace with your database username
$password = ""; // replace with your database password
$dbname = "opticien"; // replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["id_user"]) && isset($_POST["login"]) && isset($_POST["password"]) && isset($_POST["type_user"])) {
    $id_user = htmlspecialchars($_POST["id_user"]);
    $login = htmlspecialchars($_POST["login"]);
    $password = htmlspecialchars($_POST["password"]);
    $type_user = htmlspecialchars($_POST["type_user"]);

    // SQL query to update data in the users table
    $sql = "UPDATE user SET login='$login', password='$password', type_user='$type_user' WHERE id_user='$id_user'";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Please fill all fields.";
}

// Close the database connection
$conn->close();
?>

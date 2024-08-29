<?php
// Assuming you already have a connection to the database established
include 'database_connection.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_POST['id_user'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $type_user = $_POST['type_user'];

    // Insert the user data into the database
    $stmt = $conn->prepare("INSERT INTO users (id_user, login, password, type_user) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $id_user, $login, $password, $type_user);

    if ($stmt->execute()) {
        // If the insert is successful, return the user data as JSON
        echo json_encode([
            'status' => 'success',
            'id_user' => $id_user,
            'login' => $login,
            'password' => $password,
            'type_user' => $type_user
        ]);
    } else {
        // If there's an error, return an error message
        echo json_encode(['status' => 'error', 'message' => 'Failed to add user.']);
    }
    
    $stmt->close();
    $conn->close();
}
?>

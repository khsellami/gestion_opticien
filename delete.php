<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id_user = intval($_GET['id']);
    
    $sql = "DELETE FROM user WHERE id_user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_user);

    if ($stmt->execute()) 
    {
        echo "User has been deleted successfully";
    } else 
    {
        echo "Error deleting user: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: users.php");
    exit();
} else {
    echo "Invalid request";
}
?>
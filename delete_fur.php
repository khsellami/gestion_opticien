<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id_fur = intval($_GET['id']);
    
    $sql = "DELETE FROM furnisher WHERE id_fur = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_fur);

    if ($stmt->execute()) 
    {
        echo "Furnisher has been deleted successfully";
    } else 
    {
        echo "Error deleting furnisher: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: furnishers.php");
    exit();
} else {
    echo "Invalid request";
}
?>

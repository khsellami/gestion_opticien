<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id_glass = intval($_GET['id']);
    $sql = "DELETE FROM glass WHERE id_glass = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_glass);

    if ($stmt->execute()) {
        echo "Glass has been deleted successfully";
    } else {
        echo "Error deleting glass: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: glasses.php");
    exit();
} else {
    echo "Invalid request";
}
?>

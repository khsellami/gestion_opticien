<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id_cmd = intval($_GET['id']);
    
    $sql = "DELETE FROM commande WHERE id_cmd = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_cmd);

    if ($stmt->execute()) {
        echo "Command has been deleted successfully";
    } else {
        echo "Error deleting command: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: commands.php");
    exit();
} else {
    echo "Invalid request";
}
?>

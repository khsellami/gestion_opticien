<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id_client = intval($_GET['id']);

    $sql = "DELETE FROM client WHERE id_client = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_client);

    if ($stmt->execute()) 
    {
        header("Location: customers.php?message=Client deleted successfully");
    } else 
    {
        header("Location: customers.php?message=Error deleting client: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request";
    exit();
}
?>

<?php
include 'db_connection.php';

$sql = "SELECT COUNT(*) AS command_count FROM commande";

$stmt = $conn->prepare($sql);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

$command_count = $row['command_count'];

$stmt->close();
$conn->close();
?>

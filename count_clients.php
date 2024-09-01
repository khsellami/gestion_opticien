<?php
include 'db_connection.php';

$sql = "SELECT COUNT(*) AS client_count FROM client";

$stmt = $conn->prepare($sql);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

$client_count = $row['client_count'];

$stmt->close();
$conn->close();
?>

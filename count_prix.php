<?php
include 'db_connection.php';

$sql = "SELECT SUM(prix) AS total_sales FROM commande";

$stmt = $conn->prepare($sql);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

$prix = $row['total_sales'];

$stmt->close();
$conn->close();
?>

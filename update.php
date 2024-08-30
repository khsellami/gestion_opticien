<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id_user = intval($_GET['id']);
    $sql = "SELECT id_user, login, password, type_user FROM user WHERE id_user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $stmt->bind_result($id_user, $login, $password, $type_user);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "Invalid request";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $type_user = $_POST['type_user'];

    $sql = "UPDATE user SET login = ?, password = ?, type_user = ? WHERE id_user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $login, $password, $type_user, $id_user);

    if ($stmt->execute()) {
        echo "User updated successfully";
    } else {
        echo "Error updating user: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: users.php");
    exit();
}
?>

<form method="POST">
    <label>Login:</label>
    <input type="text" name="login" value="<?php echo htmlspecialchars($login); ?>" required><br>
    <label>Password:</label>
    <input type="password" name="password" value="<?php echo htmlspecialchars($password); ?>" required><br>
    <label>Type User:</label>
    <input type="text" name="type_user" value="<?php echo htmlspecialchars($type_user); ?>" required><br>
    <input type="submit" value="Update User">
</form>
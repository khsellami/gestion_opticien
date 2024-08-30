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

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" type="text/css" href="form.css" media="screen">
</head>
<body>
    <h1>Update User</h1>
    <form method="POST" action="">
        <div class="campo">
            <label for="login"><strong>Login: </strong></label>
            <input type="text" name="login" id="login" value="<?php echo htmlspecialchars($login); ?>" required>
        </div>
        <div class="campo">
            <label for="password"><strong>Password: </strong></label>
            <input type="password" name="password" id="password" value="<?php echo htmlspecialchars($password); ?>" required>
        </div>
        <div class="campo">
            <label for="type_user"><strong>Type: </strong></label>
            <select id="type_user" name="type_user" required>
                <option value="Simple" <?php echo ($type_user == 'Simple') ? 'selected' : ''; ?>>Simple</option>
                <option value="Admin" <?php echo ($type_user == 'Admin') ? 'selected' : ''; ?>>Admin</option>
            </select>
        </div>
        <button class="botao" type="submit">Update User</button>
    </form>
</body>
</html>

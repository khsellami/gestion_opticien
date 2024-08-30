<!-- add.php -->
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User</title>
    <link rel="stylesheet" type="text/css" href="form.css" media="screen">
</head>
<body>
    <h1>Add New User</h1>
    <form method="POST" action="add.php">
        <div class="campo">
            <label for="id_user"><strong>Id_user: </strong></label>
            <input type="text" name="id_user" id="id_user" required>
        </div>
        <div class="campo">
            <label for="login"><strong>Login: </strong></label>
            <input type="text" name="login" id="login" required>
        </div>
        <div class="campo">
            <label for="password"><strong>Password: </strong></label>
            <input type="password" name="password" id="password" required>
        </div>
        <div class="campo">
            <label for="type_user"><strong>Type: </strong></label>
            <select id="type_user" name="type_user" required>
                <option value="Simple">Simple</option>
                <option value="Admin">Admin</option>
            </select>
        </div>
        <button class="botao" type="submit" name="submit">Add User</button>
    </form>
</body>
</html>
<?php
// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get form data
    $id_user = $_POST['id_user'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $type_user = $_POST['type_user'];

    // Database connection settings
    $servername = "localhost"; // Your server name
    $username = "root"; // Your database username
    $dbpassword = ""; // Your database password
    $dbname = "opticien"; // Your database name

    // Create a connection to the database
    $conn = new mysqli($servername, $username, $dbpassword, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind the SQL statement to avoid SQL injection
    $stmt = $conn->prepare("INSERT INTO user (id_user, login, password, type_user) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $id_user, $login, $password, $type_user);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New user added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

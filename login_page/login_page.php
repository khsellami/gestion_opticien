<?php
include '../db_connection.php';
$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $sql = "SELECT * FROM user WHERE login = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        session_start();
        $_SESSION['user'] = $username;
        header("Location: ../index.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display-swap");

*
{
	margin: 0;
	padding: 0;
	box-sizing: border-box;
	font-family: "Poppins", sans-serif;
}
.body {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: url('pic2.jpg') no-repeat;
    background-size: cover;
    background-position: center;
}

.wrapper
{
	width: 420px;
	background: transparent;
	border: 2px solid rgba(255, 255, 255, .2);
	backdrop-filter: blur(20px);
	box-shadow: 0 0 10px rgba(0, 0, 0, .1);
	color: #fff;
	border-radius: 10px;
	padding: 30px 40px;
}

.wrapper h1
{
	font-size: 36px;
	text-align: center;
}
.wrapper .input-box
{
	position: relative;
	width: 100%;
	height: 50px;
	margin: 30px 0;
}

.input-box input
{
	width: 100%;
	height: 100%;
	background: transparent;
	border: none;
	outline: none;
	border: 2px solid rgba(255, 255, 255, .2);
	border-radius: 40px;
	font-size: 16px;
	color: #fff;
	padding: 20px 45px 20px 20px;
}
.input-box input::placeholder
{
	color: #fff;
}
.input-box i
{
	position: absolute;
	right: 20px;
	top: 50%;
	transform: translateY(-50%);
	font-size: 20px;
}

.wrapper .remember-forgot
{
	display: flex;
	justify-content: space-between;
	font-size: 14.5px;
	margin: -15px 0 15px;
}

.remember-forgot label input
{
	accent-color: #fff;
	margin-right: 3px
}

.remember-forgot a
{
	color: #fff;
	text-decoration: none;
}

.remember-forgot a:hover
{
	text-decoration: underline;
}

.wrapper .btn
{
	width: 100%;
	height: 45px;
	background: #fff;
	border: none;
	outline: none;
	border-radius: 40px;
	box-shadow: 0 0 10px rgba(0, 0, 0, .1);
	cursor: pointer;
	font-size: 16px;
	color: #333;
	font-weight: 600;
}

.wrapper .register-link
{
	font-size: 14.5px;
	text-align: center;
	margin: 20px 0 15px;

}
.register-link p a
{
	color: #fff;
	text-decoration: none;
	font-weight: 600;
}

.register-link p a:hover{
	text-decoration: underline;
}

    </style>
</head>
<body class="body" style="background-color: rebeccapurple;">
    <div class="wrapper">
        <form action="login_page.php" method="POST">
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <div class="remember-forgot">
                <label><input type="checkbox" name="remember"> Remember me</label>
                <a href="#">Forgot password?</a>
            </div>
            <?php if (!empty($error)) : ?>
                <p style="color: red; text-align: center;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>

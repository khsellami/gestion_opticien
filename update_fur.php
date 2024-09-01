<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id_fur = intval($_GET['id']);
    $sql = "SELECT id_fur, marque, tele_fur, adresse_fur, email_fur FROM furnisher WHERE id_fur = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_fur);
    $stmt->execute();
    $stmt->bind_result($id_fur, $marque, $tele_fur, $adresse_fur, $email_fur);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "Invalid request";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $marque = $_POST['marque'];
    $tele_fur = $_POST['tele_fur'];
    $adresse_fur = $_POST['adresse_fur'];
    $email_fur = $_POST['email_fur'];

    $sql = "UPDATE furnisher SET marque = ?, tele_fur = ?, adresse_fur = ?, email_fur = ? WHERE id_fur = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $marque, $tele_fur, $adresse_fur, $email_fur, $id_fur);

    if ($stmt->execute()) {
        echo "Furnisher updated successfully";
    } else {
        echo "Error updating furnisher: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: furnishers.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Update Furnisher</title>
</head>

<body>

    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="#" class="brand">
            <i class='bx bx-glasses'></i>
            <span class="text">Optician</span>
        </a>
        <ul class="side-menu top">
            <li>
                <a href="index.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="commands.php">
                    <i class='bx bxs-shopping-bag-alt'></i>
                    <span class="text">Commands</span>
                </a>
            </li>
            <li class="active">
                <a href="furnishers.php">
                    <i class='bx bx-store'></i>
                    <span class="text">Furnishers</span>
                </a>
            </li>
            <li>
                <a href="users.php">
                    <i class='bx bxs-user'></i>
                    <span class="text">Users</span>
                </a>
            </li>
            <li>
            <a href="glasses.php">
            <i class='bx bx-glasses'></i>
                    <span class="text">Glasses</span>
                </a>
            </li>
            <li>
                <a href="customers.php">
                    <i class='bx bxs-group'></i>
                    <span class="text">Customers</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="settings.php">
                    <i class='bx bxs-cog'></i>
                    <span class="text">Settings</span>
                </a>
            </li>
            <li>
                <a href="login_page/login_page.php" class="logout">
                    <i class='bx bxs-log-out-circle'></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- SIDEBAR -->

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu'></i>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <a href="#" class="profile">
                <img src="img/people.png">
            </a>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <div class="container mx-auto px-4 py-6">
                <form method="POST" action="" class="max-w-lg mx-auto bg-white p-8 rounded-xl shadow-lg mt-10">
                    <h2 class="text-2xl font-semibold mb-6 text-center text-gray-800">Update Furnisher</h2>
                    <div class="mb-5">
                        <label for="marque" class="block text-sm font-medium text-gray-700 mb-1">Marque</label>
                        <input type="text" name="marque" id="marque" value="<?php echo htmlspecialchars($marque); ?>" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:border-transparent" required>
                    </div>
                    <div class="mb-5">
                        <label for="tele_fur" class="block text-sm font-medium text-gray-700 mb-1">Telephone</label>
                        <input type="text" name="tele_fur" id="tele_fur" value="<?php echo htmlspecialchars($tele_fur); ?>" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                    </div>
                    <div class="mb-5">
                        <label for="adresse_fur" class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                        <input type="text" name="adresse_fur" id="adresse_fur" value="<?php echo htmlspecialchars($adresse_fur); ?>" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                    </div>
                    <div class="mb-5">
                        <label for="email_fur" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email_fur" id="email_fur" value="<?php echo htmlspecialchars($email_fur); ?>" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:border-transparent" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" name="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">Update Furnisher</button>
                    </div>
                </form>
            </div>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <script src="script.js"></script>
</body>

</html>

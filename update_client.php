<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id_client = intval($_GET['id']);
    $sql = "SELECT id_client, nom_client, prenom_client, email_client, assurance FROM client WHERE id_client = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_client);
    $stmt->execute();
    $stmt->bind_result($id_client, $nom_client, $prenom_client, $email_client, $assurance);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "Invalid request";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom_client = $_POST['nom_client'];
    $prenom_client = $_POST['prenom_client'];
    $email_client = $_POST['email_client'];
    $assurance = $_POST['assurance'];

    $sql = "UPDATE client SET nom_client = ?, prenom_client = ?, email_client = ?, assurance = ? WHERE id_client = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nom_client, $prenom_client, $email_client, $assurance, $id_client);

    if ($stmt->execute()) {
        echo "<script>alert('Client updated successfully.'); window.location.href='customers.php';</script>";
    } else {
        echo "<script>alert('Error updating client: " . $stmt->error . "');</script>";
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
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Update Client</title>
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
            <li>
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
            <li class="active">
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
                    <h2 class="text-2xl font-semibold mb-6 text-center text-gray-800">Update Client</h2>
                    <div class="mb-5">
                        <label for="nom_client" class="block text-sm font-medium text-gray-700 mb-1">Nom Client</label>
                        <input type="text" name="nom_client" id="nom_client" value="<?php echo htmlspecialchars($nom_client); ?>" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:border-transparent" required>
                    </div>
                    <div class="mb-5">
                        <label for="prenom_client" class="block text-sm font-medium text-gray-700 mb-1">Prenom Client</label>
                        <input type="text" name="prenom_client" id="prenom_client" value="<?php echo htmlspecialchars($prenom_client); ?>" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:border-transparent" required>
                    </div>
                    <div class="mb-5">
                        <label for="email_client" class="block text-sm font-medium text-gray-700 mb-1">Email Client</label>
                        <input type="email" name="email_client" id="email_client" value="<?php echo htmlspecialchars($email_client); ?>" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:border-transparent" required>
                    </div>
                    <div class="mb-5">
                        <label for="assurance" class="block text-sm font-medium text-gray-700 mb-1">Assurance</label>
                        <input type="text" name="assurance" id="assurance" value="<?php echo htmlspecialchars($assurance); ?>" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                    </div>
                    <div class="text-center">
                        <button type="submit" name="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">Update Client</button>
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

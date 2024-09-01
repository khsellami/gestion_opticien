<?php
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid ID.");
}

$id = $_GET['id'];

$servername = "localhost";
$username = "root";
$dbpassword = ""; 
$dbname = "opticien";

$conn = new mysqli($servername, $username, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT libelle, type, type_glass, SPH, cylindre FROM glass WHERE id_glass = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$glass = $result->fetch_assoc();

if (!$glass) {
    die("Glass not found.");
}

if (isset($_POST['submit'])) {
    $libelle = $_POST['libelle'];
    $type = $_POST['type'];
    $type_glass = $_POST['type_glass'];
    $SPH = $_POST['SPH'];
    $cylindre = $_POST['cylindre'];

    $stmt = $conn->prepare("UPDATE glass SET libelle = ?, type = ?, type_glass = ?, SPH = ?, cylindre = ? WHERE id_glass = ?");
    $stmt->bind_param("sssssi", $libelle, $type, $type_glass, $SPH, $cylindre, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Glass updated successfully.'); window.location.href='glasses.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

$conn->close();
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
    <title>Update Glass</title>
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
                <form method="POST" action="update_glass.php?id=<?php echo $id; ?>" class="max-w-lg mx-auto bg-white p-8 rounded-xl shadow-lg mt-10">
                    <h2 class="text-2xl font-semibold mb-6 text-center text-gray-800">Update Glass</h2>
                    <div class="mb-5">
                        <label for="libelle" class="block text-sm font-medium text-gray-700 mb-1">Libelle</label>
                        <input type="text" name="libelle" id="libelle" value="<?php echo htmlspecialchars($glass['libelle']); ?>" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:border-transparent" required>
                    </div>
                    <div class="mb-5">
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                        <select name="type" id="type" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:border-transparent" required>
                            <option value="optique" <?php echo $glass['type'] == 'optique' ? 'selected' : ''; ?>>Optique</option>
                            <option value="solaire" <?php echo $glass['type'] == 'solaire' ? 'selected' : ''; ?>>Solaire</option>
                        </select>
                    </div>
                    <div class="mb-5">
                        <label for="type_glass" class="block text-sm font-medium text-gray-700 mb-1">Type of Glass</label>
                        <select name="type_glass" id="type_glass" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:border-transparent" required>
                            <option value="antireflet" <?php echo $glass['type_glass'] == 'antireflet' ? 'selected' : ''; ?>>Antireflet</option>
                            <option value="bleu" <?php echo $glass['type_glass'] == 'bleu' ? 'selected' : ''; ?>>Bleu</option>
                            <option value="blanc" <?php echo $glass['type_glass'] == 'blanc' ? 'selected' : ''; ?>>Blanc</option>
                        </select>
                    </div>
                    <div class="mb-5">
                        <label for="SPH" class="block text-sm font-medium text-gray-700 mb-1">SPH</label>
                        <select name="SPH" id="SPH" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:border-transparent" required>
                            <?php for ($i = -12; $i <= 12; $i += 0.25): ?>
                                <option value="<?php echo number_format($i, 2); ?>" <?php echo number_format($i, 2) == $glass['SPH'] ? 'selected' : ''; ?>><?php echo number_format($i, 2); ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="mb-5">
                        <label for="cylindre" class="block text-sm font-medium text-gray-700 mb-1">Cylindre</label>
                        <select name="cylindre" id="cylindre" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:border-transparent" required>
                            <?php for ($i = -5; $i <= 5; $i += 0.25): ?>
                                <option value="<?php echo number_format($i, 2); ?>" <?php echo number_format($i, 2) == $glass['cylindre'] ? 'selected' : ''; ?>><?php echo number_format($i, 2); ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="text-center">
                        <button type="submit" name="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">Update Glass</button>
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

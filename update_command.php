<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id_cmd = intval($_GET['id']);
    $sql = "SELECT id_cmd, date_cmd, prix, type_glass, type_lunette, SPH_OD, SPH_OG, cylindre_OD, cylindre_OG, axe_OD, axe_OG, distance_OD, distance_OG, id_client, id_user 
            FROM commande 
            WHERE id_cmd = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_cmd);
    $stmt->execute();
    $stmt->bind_result($id_cmd, $date_cmd, $prix, $type_glass, $type_lunette, $SPH_OD, $SPH_OG, $cylindre_OD, $cylindre_OG, $axe_OD, $axe_OG, $distance_OD, $distance_OG, $id_client, $id_user);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "Invalid request";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date_cmd = $_POST['date_cmd'];
    $prix = $_POST['prix'];
    $type_glass = $_POST['type_glass'];
    $type_lunette = $_POST['type_lunette'];
    $SPH_OD = $_POST['SPH_OD'];
    $SPH_OG = $_POST['SPH_OG'];
    $cylindre_OD = $_POST['cylindre_OD'];
    $cylindre_OG = $_POST['cylindre_OG'];
    $axe_OD = $_POST['axe_OD'];
    $axe_OG = $_POST['axe_OG'];
    $distance_OD = $_POST['distance_OD'];
    $distance_OG = $_POST['distance_OG'];
    $nom_client = $_POST['nom_client'];
    $login_user = $_POST['login_user'];

    $stmt_client = $conn->prepare("SELECT id_client FROM client WHERE nom_client = ?");
    $stmt_client->bind_param('s', $nom_client);
    $stmt_client->execute();
    $stmt_client->bind_result($id_client);
    $stmt_client->fetch();
    $stmt_client->close();

    $stmt_user = $conn->prepare("SELECT id_user FROM user WHERE login = ?");
    $stmt_user->bind_param('s', $login_user);
    $stmt_user->execute();
    $stmt_user->bind_result($id_user);
    $stmt_user->fetch();
    $stmt_user->close();

    $sql_update_cmd = "UPDATE commande 
                       SET date_cmd = ?, prix = ?, type_glass = ?, type_lunette = ?, SPH_OD = ?, SPH_OG = ?, cylindre_OD = ?, cylindre_OG = ?, axe_OD = ?, axe_OG = ?, distance_OD = ?, distance_OG = ?, id_client = ?, id_user = ? 
                       WHERE id_cmd = ?";
    $stmt_update_cmd = $conn->prepare($sql_update_cmd);
    $stmt_update_cmd->bind_param('ssssssssssssiii', $date_cmd, $prix, $type_glass, $type_lunette, $SPH_OD, $SPH_OG, $cylindre_OD, $cylindre_OG, $axe_OD, $axe_OG, $distance_OD, $distance_OG, $id_client, $id_user, $id_cmd);

    if ($stmt_update_cmd->execute()) {
        echo "Command updated successfully";
    } else {
        echo "Error updating command: " . $conn->error;
    }

    $stmt_update_cmd->close();
    $conn->close();

    header("Location: commands.php");
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
    <title>Update Command</title>
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
            <li class="active">
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
            <form action="add_cmd.php" method="POST" class="bg-white p-6 rounded-lg shadow-md">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700">Date Command</label>
            <input type="date" name="date_cmd" class="mt-1 block w-full border-gray-300 rounded-md" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Price</label>
            <input type="number" name="prix" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Type Glass</label>
            <select name="type_glass" class="mt-1 block w-full border-gray-300 rounded-md" required>
                <option value="bleu">Bleu</option>
                <option value="blanc">Blanc</option>
                <option value="anti reflet">Anti Reflet</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Type Lunette</label>
            <select name="type_lunette" class="mt-1 block w-full border-gray-300 rounded-md" required>
                <option value="solaire">Solaire</option>
                <option value="optique">Optique</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">SPH OD</label>
            <select name="SPH_OD" class="mt-1 block w-full border-gray-300 rounded-md">
                <?php for ($i = -12; $i <= 12; $i += 0.25): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">SPH OG</label>
            <select name="SPH_OG" class="mt-1 block w-full border-gray-300 rounded-md">
                <?php for ($i = -12; $i <= 12; $i += 0.25): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Cylindre OD</label>
            <select name="cylindre_OD" class="mt-1 block w-full border-gray-300 rounded-md">
                <?php for ($i = -5; $i <= 5; $i += 0.25): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Cylindre OG</label>
            <select name="cylindre_OG" class="mt-1 block w-full border-gray-300 rounded-md">
                <?php for ($i = -5; $i <= 5; $i += 0.25): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Axe OD</label>
            <input type="number" name="axe_OD" min="-5" max="5" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Axe OG</label>
            <input type="number" name="axe_OG" min="-5" max="5" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Distance OD</label>
            <input type="number" name="distance_OD" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Distance OG</label>
            <input type="number" name="distance_OG" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Client Name</label>
            <input type="text" name="nom_client" class="mt-1 block w-full border-gray-300 rounded-md">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">User Login</label>
            <input type="text" name="login_user" class="mt-1 block w-full border-gray-300 rounded-md">
        </div>
    </div>
    <div class="mt-8">
        <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">Add Command</button>
    </div>
</form>
            </div>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

</body>
</html>

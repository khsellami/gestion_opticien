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
    <title>Add New Furnisher</title>
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
                <form method="POST" action="add_fur.php" class="max-w-lg mx-auto bg-white p-8 rounded-xl shadow-lg mt-10">
                    <h2 class="text-2xl font-semibold mb-6 text-center text-gray-800">Add New Furnisher</h2>
                    <div class="mb-5">
                        <label for="marque" class="block text-sm font-medium text-gray-700 mb-1">Marque</label>
                        <input type="text" name="marque" id="marque" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:border-transparent" required>
                    </div>
                    <div class="mb-5">
                        <label for="tele_fur" class="block text-sm font-medium text-gray-700 mb-1">Telephone</label>
                        <input type="text" name="tele_fur" id="tele_fur" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:border-transparent" required>
                    </div>
                    <div class="mb-5">
                        <label for="email_fur" class="block text-sm font-medium text-gray-700 mb-1">Email Furnisher</label>
                        <input type="email" name="email_fur" id="email_fur" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:border-transparent" required>
                    </div>
                    <div class="mb-5">
                        <label for="adresse_fur" class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                        <input type="text" name="adresse_fur" id="adresse_fur" class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                    </div>
                    <div class="text-center">
                        <button type="submit" name="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">Add Furnisher</button>
                    </div>
                </form>
            </div>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <?php
    if (isset($_POST['submit'])) {
        $marque = $_POST['marque'];
        $tele_fur = $_POST['tele_fur'];
        $email_fur = $_POST['email_fur'];
        $adresse_fur = $_POST['adresse_fur'];

        $servername = "localhost";
        $username = "root";
        $dbpassword = "";
        $dbname = "opticien";

        $conn = new mysqli($servername, $username, $dbpassword, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO furnisher (marque, tele_fur, email_fur, adresse_fur) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $marque, $tele_fur, $email_fur, $adresse_fur);

        if ($stmt->execute()) {
            $id_fur = $stmt->insert_id;

            $sql_glasses = "SELECT id_glass FROM glass WHERE libelle = ?";
            $stmt_glasses = $conn->prepare($sql_glasses);
            $stmt_glasses->bind_param("s", $marque);
            $stmt_glasses->execute();
            $result_glasses = $stmt_glasses->get_result();

            $insert_detail = "INSERT INTO details_fur_glass (id_fur, id_glass) VALUES (?, ?)";
            $stmt_detail = $conn->prepare($insert_detail);

            while ($row = $result_glasses->fetch_assoc()) {
                $id_glass = $row['id_glass'];
                $stmt_detail->bind_param("ii", $id_fur, $id_glass);
                $stmt_detail->execute();
            }

            echo "<script>alert('New furnisher added successfully.'); window.location.href='furnishers.php';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }

        $stmt->close();
        $stmt_glasses->close();
        $stmt_detail->close();
        $conn->close();
    }
    ?>

    <script src="script.js"></script>
</body>

</html>

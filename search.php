<?php
include 'db_connection.php';

$query = isset($_GET['query']) ? trim($_GET['query']) : '';

$sql = "SELECT id_user, login, password, type_user FROM user WHERE id_user LIKE ? OR login LIKE ?";

$stmt = $conn->prepare($sql);

$searchTerm = '%' . $query . '%';
$stmt->bind_param('ss', $searchTerm, $searchTerm);

$stmt->execute();

$result = $stmt->get_result();
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
    <title>Search Results</title>
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
            <div class="container mx-auto px-4">
                <header class="flex justify-between mb-4">
                    <button onclick="window.location.href='add.php';" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">
                        Add User
                    </button>
                    <form action="search.php" method="GET" class="flex">
                        <input type="text" name="query" value="<?php echo htmlspecialchars($query); ?>" placeholder="Search by ID or Login" class="px-4 py-2 border rounded-l focus:outline-none w-64">
                        <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded-r">
                            Search
                        </button>
                    </form>
                </header>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-gray-800 text-white rounded-lg overflow-hidden shadow-lg">
                        <thead class="bg-gray-700">
                            <tr>
                                <th class="py-3 px-5 text-left text-sm font-medium uppercase tracking-wider">ID_User</th>
                                <th class="py-3 px-5 text-left text-sm font-medium uppercase tracking-wider">Login</th>
                                <th class="py-3 px-5 text-left text-sm font-medium uppercase tracking-wider">Password</th>
                                <th class="py-3 px-5 text-left text-sm font-medium uppercase tracking-wider">Type User</th>
                                <th class="py-3 px-5 text-left text-sm font-medium uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-600">
                            <?php
                            if ($result->num_rows > 0) {
                                while ($user = $result->fetch_assoc()) {
                                    echo "<tr class='hover:bg-gray-700 transition duration-200'>";
                                    echo "<td class='py-3 px-5 text-sm'>{$user['id_user']}</td>";
                                    echo "<td class='py-3 px-5 text-sm'>{$user['login']}</td>";
                                    echo "<td class='py-3 px-5 text-sm'>{$user['password']}</td>";
                                    echo "<td class='py-3 px-5 text-sm'>{$user['type_user']}</td>";
                                    echo "<td class='py-3 px-5 text-sm'>
                                            <a href='update.php?id={$user['id_user']}' class='text-blue-400 hover:text-blue-300'>Update</a> | 
                                            <a href='delete.php?id={$user['id_user']}' class='text-red-400 hover:text-red-300' onclick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a>
                                          </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center py-4 text-sm text-gray-400'>No users found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <script src="script.js"></script>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>

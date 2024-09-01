<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <title>Homepage</title>
</head>
<body>

    <!-- SIDEBAR -->
    <section id="sidebar">
		<a href="#" class="brand">
            <i class='bx bx-glasses'></i>
			<span class="text">Optician</span>
		</a>
		<ul class="side-menu top">
			<li class="active">
				<a href="index.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="commands.php">
					<i class='bx bxs-shopping-bag-alt' ></i>
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
                <i class='bx bxs-user' ></i>
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
					<i class='bx bxs-group' ></i>
					<span class="text">Customers</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="settings.php">
					<i class='bx bxs-cog' ></i>
					<span class="text">Settings</span>
				</a>
			</li>
			<li>
				<a href="login_page/login_page.php" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
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
			<i class='bx bx-menu' ></i>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
		</nav>
	<!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Dashboard</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Dashboard</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="#">Home</a>
                        </li>
                    </ul>
                </div>
            </div>
            <?php include 'count_clients.php'; ?>
            <?php include 'count_prix.php'; ?>
            <?php include 'count_commandes.php'; ?>
            <ul class="box-info">
                <li>
                    <i class='bx bxs-calendar-check'></i>
                    <span class="text">
                        <h3><?php echo htmlspecialchars($command_count); ?></h3>
                        <p>Commands</p>
                    </span>
                </li>
                <li>
                    <i class='bx bxs-group'></i>
                    <span class="text">
                        <h3><?php echo htmlspecialchars($client_count); ?></h3>
                        <p>Customers</p>
                    </span>
                </li>
                <li>
                    <i class='bx bxs-dollar-circle'></i>
                    <span class="text">
                        <h3><?php echo htmlspecialchars($prix); ?></h3>
                        <p>Total Sales</p>
                    </span>
                </li>
            </ul>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Recent Orders</h3>
                        <!-- SEARCH FORM -->
                        <form action="index.php" method="GET">
                            <div class="form-input">
                                <input type="search" name="search" id="search-input" placeholder="Search...">
                                <button type="submit" id="search-btn" class="search-btn">
                                    <i class='bx bx-search'></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <table id="orders-table">
                        <thead>
                            <tr>
                                <th>Client Name</th>
                                <th>Client Surname</th>
                                <th>Email</th>
                                <th>Order Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include 'db_connection.php';

                            $search = isset($_GET['search']) ? $_GET['search'] : '';

                            $sql = "
                                SELECT client.nom_client, client.prenom_client, client.email_client, commande.date_cmd
                                FROM commande
                                JOIN client ON commande.id_client = client.id_client
                                WHERE client.nom_client LIKE ? OR commande.date_cmd LIKE ?
                            ";

                            $stmt = $conn->prepare($sql);

                            $searchTerm = "%{$search}%";
                            $stmt->bind_param('ss', $searchTerm, $searchTerm);
                            $stmt->execute();

                            $result = $stmt->get_result();

                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($row['nom_client']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['prenom_client']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['email_client']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['date_cmd']) . '</td>';
                                echo '</tr>';
                            }

                            $stmt->close();
                            $conn->close();
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

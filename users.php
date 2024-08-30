<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="style.css">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
	<title>Homepage</title>
	<!-- Add this script section to users.html -->
<!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the form from submitting the default way

            // Collect form data
            const formData = new FormData(form);

            // Send an AJAX request to add_user.php
            fetch('add_user.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // If the user is successfully added, update the table
                    const tableBody = document.querySelector('.userInfo');
                    const newRow = document.createElement('tr');

                    newRow.innerHTML = `
                        <td>${data.id_user}</td>
                        <td>${data.login}</td>
                        <td>${data.password}</td>
                        <td>${data.type_user}</td>
                        <td class="actions">
                            <a href="update.php?id=${data.id_user}" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                            <a href="delete.php?id=${data.id_user}" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                        </td>
                    `;

                    // Append the new row to the table
                    tableBody.appendChild(newRow);

                    // Optionally, reset the form fields
                    form.reset();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
</script> -->

</head>

<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">Optician</span>
		</a>
		<ul class="side-menu top">
			<li class="active">
				<a href="index.html">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="commands.html">
					<i class='bx bxs-shopping-bag-alt' ></i>
					<span class="text">Commands</span>
				</a>
			</li>
			<li>
				<a href="furnishers.html">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text">Furnishers</span>
				</a>
			</li>
			<li>
				<a href="users.php">
					<i class='bx bxs-group' ></i>
					<span class="text">Users</span>
				</a>
			</li>
			<li>
				<a href="glasses.html">
					<i class='bx bxs-message-dots' ></i>
					<span class="text">Glasses</span>
				</a>
			</li>
			<li>
				<a href="customers.html">
					<i class='bx bxs-group' ></i>
					<span class="text">Customers</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="#">
					<i class='bx bxs-cog' ></i>
					<span class="text">Settings</span>
				</a>
			</li>
			<li>
				<a href="#" class="logout">
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
			<a href="#" class="profile">
				<img src="img/people.png">
			</a>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
    <div class="container">
        <header>
            <button onclick="window.location.href='add.php';" class="btn-add">Add User</button>
        </header>
        <div class="p-6 overflow-scroll px-0">
            <table class="mt-4 w-full min-w-max table-auto text-left">
                <thead>
                    <tr class="bg-blue-gray-50/50">
                        <th class="cursor-pointer border-y border-blue-gray-100 p-4 transition-colors hover:bg-blue-gray-50">ID_User</th>
                        <th class="cursor-pointer border-y border-blue-gray-100 p-4 transition-colors hover:bg-blue-gray-50">Login</th>
                        <th class="cursor-pointer border-y border-blue-gray-100 p-4 transition-colors hover:bg-blue-gray-50">Password</th>
                        <th class="cursor-pointer border-y border-blue-gray-100 p-4 transition-colors hover:bg-blue-gray-50">Type User</th>
                        <th class="cursor-pointer border-y border-blue-gray-100 p-4 transition-colors hover:bg-blue-gray-50">Actions</th>
                    </tr>
                </thead>
                <tbody class="userInfo">
                    <?php
                    include 'db_connection.php';
                    $sql = "SELECT id_user, login, password, type_user FROM user";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($user = $result->fetch_assoc()) {
                            echo "<tr class='border-b border-blue-gray-50'>";
                            echo "<td class='p-4 text-blue-gray-900'>{$user['id_user']}</td>";
                            echo "<td class='p-4 text-blue-gray-900'>{$user['login']}</td>";
                            echo "<td class='p-4 text-blue-gray-900'>{$user['password']}</td>";
                            echo "<td class='p-4 text-blue-gray-900'>{$user['type_user']}</td>";
                            echo "<td class='p-4'>
                                    <a href='update.php?id={$user['id_user']}' class='text-blue-500 hover:underline'>Update</a> | 
                                    <a href='delete.php?id={$user['id_user']}' class='text-red-500 hover:underline' onclick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='p-4 text-center'>No users found</td></tr>";
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

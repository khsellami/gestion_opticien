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
        <?php
include 'db_connection.php';

$query = "SELECT * FROM settings WHERE id = 1";
$result = $conn->query($query);
$settings = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $clinicName = $_POST['clinic_name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $openingHours = $_POST['opening_hours'];
    $closingHours = $_POST['closing_hours'];
    $appointmentDuration = $_POST['appointment_duration'];

    $stmt = $conn->prepare("UPDATE settings SET clinic_name = ?, address = ?, phone = ?, email = ?, opening_hours = ?, closing_hours = ?, appointment_duration = ? WHERE id = 1");
    $stmt->bind_param('ssssssi', $clinicName, $address, $phone, $email, $openingHours, $closingHours, $appointmentDuration);

    if ($stmt->execute()) {
        echo '<div class="container mx-auto p-4 bg-green-100 text-green-800 mb-4 rounded-lg">Settings updated successfully!</div>';
    } else {
        echo '<div class="container mx-auto p-4 bg-red-100 text-red-800 mb-4 rounded-lg">Error updating settings.</div>';
    }
    
    $stmt->close();
}
?>

        <main class="container mx-auto p-6 bg-white shadow-md rounded-lg mt-8">
    <h1 class="text-2xl font-bold mb-6">Optician Settings</h1>
    
    <form action="" method="post">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="clinic-name" class="block text-gray-700 mb-2">Clinic Name</label>
                <input type="text" id="clinic-name" name="clinic_name" class="w-full border-gray-300 rounded-lg p-2" value="<?php echo htmlspecialchars($settings['clinic_name']); ?>" placeholder="Enter clinic name">
            </div>
            <div>
                <label for="address" class="block text-gray-700 mb-2">Address</label>
                <input type="text" id="address" name="address" class="w-full border-gray-300 rounded-lg p-2" value="<?php echo htmlspecialchars($settings['address']); ?>" placeholder="Enter address">
            </div>
            <div>
                <label for="phone" class="block text-gray-700 mb-2">Phone Number</label>
                <input type="text" id="phone" name="phone" class="w-full border-gray-300 rounded-lg p-2" value="<?php echo htmlspecialchars($settings['phone']); ?>" placeholder="Enter phone number">
            </div>
            <div>
                <label for="email" class="block text-gray-700 mb-2">Email Address</label>
                <input type="email" id="email" name="email" class="w-full border-gray-300 rounded-lg p-2" value="<?php echo htmlspecialchars($settings['email']); ?>" placeholder="Enter email address">
            </div>
            <div>
                <label for="opening-hours" class="block text-gray-700 mb-2">Opening Hours</label>
                <input type="text" id="opening-hours" name="opening_hours" class="w-full border-gray-300 rounded-lg p-2" value="<?php echo htmlspecialchars($settings['opening_hours']); ?>" placeholder="Enter opening hours">
            </div>
            <div>
                <label for="closing-hours" class="block text-gray-700 mb-2">Closing Hours</label>
                <input type="text" id="closing-hours" name="closing_hours" class="w-full border-gray-300 rounded-lg p-2" value="<?php echo htmlspecialchars($settings['closing_hours']); ?>" placeholder="Enter closing hours">
            </div>
            <div>
                <label for="appointment-duration" class="block text-gray-700 mb-2">Appointment Duration (minutes)</label>
                <input type="number" id="appointment-duration" name="appointment_duration" class="w-full border-gray-300 rounded-lg p-2" value="<?php echo htmlspecialchars($settings['appointment_duration']); ?>" placeholder="Enter duration">
            </div>
        </div>
        <button type="submit" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-lg">Save Settings</button>
    </form>
</main>
	</section>
	<!-- CONTENT -->

	<script src="script.js"></script>
</body>
</html>

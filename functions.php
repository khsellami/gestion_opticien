<?php
function pdo_connect_mysql() {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'opticien';
    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
    	// If there is an error with the connection, stop the script and display the error.
    	exit('Failed to connect to database!');
    }
}
// function template_header($title) {
// echo <<<EOT
// <!DOCTYPE html>
// <html>
// 	<head>
// 		<meta charset="utf-8">
// 		<title>$title</title>
// 		<link href="style.css" rel="stylesheet" type="text/css">
// 		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
// 	</head>
// 	<body>
//     <nav class="navtop">
//     	<div>
//     		<h1>Website Title</h1>
//             <a href="index.php"><i class="fas fa-home"></i>Home</a>
//     		<a href="read.php"><i class="fas fa-address-book"></i>Contacts</a>
//     	</div>
//     </nav>
// EOT;
// }
// function template_footer() {
// echo <<<EOT
//     </body>
// </html>
// EOT;
// }
function search_data($pdo, $query) {
    // Sanitize the input query
    $query = '%' . $query . '%';

    // Prepare the SQL query to search by id or name
    $sql = "SELECT * FROM user WHERE id_user LIKE :query OR login LIKE :query";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':query', $query, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch all matching records
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $data;
}


?>




<?php
    // Check if search query is set
    if (isset($_GET['search_query'])) {
        // Get the search query
        $search_query = $_GET['search_query'];

        // Database connection settings
        $servername = "localhost"; // Your server name
        $username = "root"; // Your database username
        $dbpassword = ""; // Your database password
        $dbname = "opticien"; // Your database name

        // Create a connection to the database
        $conn = new mysqli($servername, $username, $dbpassword, $dbname);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare SQL query to search by ID or login
        $sql = "SELECT * FROM user WHERE id_user = ? OR login = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $search_query, $search_query); // Bind the same parameter twice

        // Execute the query
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if any results were found
        if ($result->num_rows > 0) {
            echo "<h2>Search Results:</h2>";
            echo "<table border='1'>
                    <tr>
                        <th>ID User</th>
                        <th>Login</th>
                        <th>Password</th>
                        <th>Type</th>
                    </tr>";

            // Fetch and display results
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['id_user']) . "</td>
                        <td>" . htmlspecialchars($row['login']) . "</td>
                        <td>" . htmlspecialchars($row['password']) . "</td>
                        <td>" . htmlspecialchars($row['type_user']) . "</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No results found for your search.</p>";
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
    ?>
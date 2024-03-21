<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database configuration
    $host = 'localhost'; // Database host
    $dbname = 'usersign'; // Database name
    $db_username = 'root'; // Database username
    $db_password = ''; // Database password

    // Create connection
    $conn = new mysqli($host, $db_username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Enable error reporting for mysqli
    $conn->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO usersign (username, password) VALUES (?, ?)");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Set parameters from the POST request
    $form_username = $_POST['username'] ?? ''; // Use the null coalescing operator to provide a default value
    $raw_password = $_POST['password'] ?? '';
    $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT); // Password hashing

    // Bind the parameters and execute
    $stmt->bind_param("ss", $form_username, $hashed_password);
    $stmt->execute();

    echo "New record created successfully";

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>

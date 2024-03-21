<?php
// Establish a database connection
$hostname = 'localhost'; // Replace with the actual hostname or IP address of your MySQL server
$username = 'root'; // Replace with your MySQL username
$password = ''; // Replace with your MySQL password
$database = 'credit'; // Replace with your database name

// Create a new database connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check for a database connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $buyerName = $conn->real_escape_string($_POST["buyer_name"]);
    $phoneNumber = $conn->real_escape_string($_POST["phone_number"]);
    $date = $conn->real_escape_string($_POST["date"]);
    $quantity = (int)$_POST["quantity"];
    $price = (float)$_POST["price"];
    $returning = $conn->real_escape_string($_POST["returning"]);
    $total = $quantity * $price; // Corrected variable name

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO credit (buyername, phoneNumber, `Date`, Quantity, Price, returningDate, total) VALUES (?, ?, ?, ?, ?, ?, ?)");

    // Bind the parameters to the statement
    $stmt->bind_param("sssiidd", $buyerName, $phoneNumber, $date, $quantity, $price, $returning, $total); // Corrected variable names

    // Execute the statement and check for errors
    if ($stmt->execute()) {
        echo "Sale added successfully. ID: " . $conn->insert_id; // Sends back the ID of the newly added record
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

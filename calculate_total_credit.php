<?php
$hostname = 'localhost'; // Replace with your MySQL server details
$username = 'root';
$password = '';
$database = 'credit'; // Ensure this is your database name

// Create a new database connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Failed to connect: " . $conn->connect_error);
}

$totalSales = 0;

// Adjust the SQL query according to your database schema
$sql = "SELECT SUM(Quantity * price) AS total FROM credit"; // Replace 'sales' with your actual table name
$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    $totalSales = $row['total'] ? $row['total'] : 0; // Check for null
}

// Indicate that the response is JSON
header('Content-Type: application/json');

// Send the response
echo json_encode(['totalSales' => $totalSales]);

$conn->close(); // Close the database connection
?>

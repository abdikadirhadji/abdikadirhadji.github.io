<?php
// ... Database connection setup ...

$hostname = 'localhost'; // Replace with your MySQL server details
$username = 'root';
$password = '';
$database = 'salestable'; // Ensure this is your database name

// Create a new database connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Failed to connect: " . $conn->connect_error);
}
$sql = "SELECT SUM(expenses) AS totalExpenses FROM salestable";
$result = $conn->query($sql);
$totalExpenses = 0;

if ($result && $row = $result->fetch_assoc()) {
    $totalExpenses = $row['totalExpenses'] ? $row['totalExpenses'] : 0;
}

header('Content-Type: application/json');
echo json_encode(['totalExpenses' => $totalExpenses]);
?>

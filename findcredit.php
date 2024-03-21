<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database credentials
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'credit';

// Create database connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check for database connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Decode JSON input from the AJAX request
$input = json_decode(file_get_contents('php://input'), true);

// Extract search parameters
$buyerName = isset($input['buyerName']) ? $conn->real_escape_string($input['buyerName']) : '';
$startDate = isset($input['startDate']) ? $input['startDate'] : '';
$endDate = isset($input['endDate']) ? $input['endDate'] : '';

// Build the SQL query for fetching sales
$sql = "SELECT * FROM credit WHERE buyername LIKE CONCAT('%', ?, '%')";
$params = array($buyerName);

// If date filters are set, modify the query
if (!empty($startDate) && !empty($endDate)) {
    $sql .= " AND Date BETWEEN ? AND ?";
    array_push($params, $startDate, $endDate);
}

// Prepare the statement for fetching sales
$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat('s', count($params)), ...$params);
$stmt->execute();
$result = $stmt->get_result();
$sales = $result->fetch_all(MYSQLI_ASSOC);

// Build the SQL query for calculating total sales
$sqlTotal = "SELECT SUM(quantity * price) AS totalSale FROM credit WHERE buyername LIKE CONCAT('%', ?, '%')";
if (!empty($startDate) && !empty($endDate)) {
    $sqlTotal .= " AND Date BETWEEN ? AND ?";
}

// Prepare the statement for total sales
$stmtTotal = $conn->prepare($sqlTotal);
$stmtTotal->bind_param(str_repeat('s', count($params)), ...$params);
$stmtTotal->execute();
$resultTotal = $stmtTotal->get_result();
$totalSales = $resultTotal->fetch_assoc()['totalSale'];

// Prepare response
$response = [
    'sales' => $sales,
    'totalSale' => $totalSales
];

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);

// Close statement and connection
$stmt->close();
$stmtTotal->close();
$conn->close();
?>

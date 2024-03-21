<?php

$hostname = 'localhost'; // Your database host
$username = 'root'; // Your database username
$password = ''; // Your database password
$database = 'credit'; // Your database name

// Create database connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pagination variables
$recordsPerPage = 8;
$currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($currentPage - 1) * $recordsPerPage;

// Prepare the SQL query with LIMIT and OFFSET
$sql = "SELECT ID, BuyerName, PhoneNumber, Date, Quantity, Price, ReturningDate, total FROM credit LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $recordsPerPage, $offset);
$stmt->execute();
$result = $stmt->get_result();

// Fetch and display data
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr data-sale-id='" . $row['ID'] . "'>";
        echo "<td>" . htmlspecialchars($row["ID"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["BuyerName"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["PhoneNumber"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["Date"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["Quantity"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["Price"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["ReturningDate"]) . "</td>";
         echo "<td>" . htmlspecialchars(number_format($row["total"], 2)) . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No results found</td></tr>";
}

// Close statement and connection
$stmt->close();
$conn->close();

?>

<?php
// Establish a database connection
$hostname = 'localhost'; // Replace with the actual hostname or IP address of your MySQL server
$username = 'root'; // Replace with your MySQL username
$password = ''; // Replace with your MySQL password
$database = 'salestable'; // Replace with your database name

// Create a new database connection
$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Failed to connect: " . $conn->connect_error);
}
// Pagination variables
$recordsPerPage = 8;
$currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($currentPage - 1) * $recordsPerPage;
// Query the database to retrieve sales history
// Query the database to retrieve sales history
$sql = "SELECT ID, BuyerName, PhoneNumber, SaleDate, Product, Quantity, SellingPrice, Expenses, total FROM salestable LIMIT ?, ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $offset, $recordsPerPage);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    // Output data of each row
  while ($row = $result->fetch_assoc()) {
  echo "<tr data-sale-id='" . $row['ID'] . "'>";
        echo "<td>" . htmlspecialchars($row["ID"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["BuyerName"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["PhoneNumber"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["SaleDate"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["Product"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["Quantity"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["SellingPrice"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["Expenses"]) . "</td>";
    echo "<td>" . htmlspecialchars(number_format($row["total"], 2)) . "</td>";

    // Add a checkbox in the last cell for potential actions like deleting
    
    echo "</tr>";
}

        
    
}else {
    echo "<tr><td colspan='8'>No results found</td></tr>";
}

// Close statement and connection
$stmt->close();
$conn->close();

?>


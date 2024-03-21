<?php
// Establish a database connection
$hostname = 'localhost'; // Replace with the actual hostname or IP address of your MySQL server
$username = 'root'; // Replace with your MySQL username
$password = ''; // Replace with your MySQL password
$database = 'salestable'; // Replace with your database name

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
    $saleDate = $conn->real_escape_string($_POST["date"]);
    $product = $conn->real_escape_string($_POST["product"]);
    $quantity = (int)$_POST["quantity"];
    $sellingPrice = (float)$_POST["price"];
    $expenses = (float)$_POST["expenses"];
    $total = $quantity * $sellingPrice;
    // Prepare the SQL statement without the ID column
 
// Prepare the SQL statement with the 'Total' column
$stmt = $conn->prepare("INSERT INTO salestable (BuyerName, PhoneNumber, SaleDate, Product, Quantity, SellingPrice, Expenses, Total) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

// Bind the parameters to the statement, including the total
$stmt->bind_param("sssidddd", $buyerName, $phoneNumber, $saleDate, $product, $quantity, $sellingPrice, $expenses, $total);

    // Execute the statement and check for errors
    if ($stmt->execute()) {
        echo "Sale added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

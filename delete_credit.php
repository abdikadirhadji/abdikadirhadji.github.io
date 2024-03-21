<?php

// Database configuration
$host = 'localhost'; // Host name
$dbname = 'credit'; // Database name
$username = 'root'; // Database username
$password = ''; // Database password

// Create a new PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}

// Check if saleId is provided
if (isset($_POST['saleId'])) {
    $saleId = $_POST['saleId'];

    // Prepare a delete statement
    $sql = "DELETE FROM credit WHERE ID = :saleId"; // Use 'ID' instead of 'sale_id'

    try {
        $stmt = $pdo->prepare($sql);
        
        // Bind parameters to statement
        $stmt->bindParam(':saleId', $saleId, PDO::PARAM_INT);
        
        // Execute the prepared statement
        $stmt->execute();

        echo "Sale deleted successfully.";
    } catch(PDOException $e) {
        die("ERROR: Could not delete record: " . $e->getMessage());
    }
} else {
    echo "No sale ID provided.";
}

// Close connection
unset($pdo);
?>

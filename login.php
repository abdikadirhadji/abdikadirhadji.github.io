<?php
$servername = "localhost"; // Your server name or IP
$username = "username"; // Your database username
$password = ""; // Your database password
$dbname = "usersign"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT password FROM usersign WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    
    if (password_verify($password, $hashed_password)) {
        echo "Login successful";
    } else {
        echo "Invalid email or password";
    }
} else {
    echo "Invalid email or password";
}

$stmt->close();
$conn->close();
?>

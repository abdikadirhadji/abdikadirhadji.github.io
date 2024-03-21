
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

$sql = "SELECT SUM(Quantity) AS totalQuantity FROM credit";
$result = $conn->query($sql);
$totalQuantity = 0;

if ($result && $row = $result->fetch_assoc()) {
    $totalQuantity = $row['totalQuantity'] ? $row['totalQuantity'] : 0;
}

header('Content-Type: application/json');
echo json_encode(['totalQuantity' => $totalQuantity]);
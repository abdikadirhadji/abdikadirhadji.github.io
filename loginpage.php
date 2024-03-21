<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>


     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
               body {
            font-family: Arial, sans-serif;
            background-image: url('background.jpg'); /* Replace with your chosen background image */
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-box {
            width: 80%; /* Responsive width */
            max-width: 400px; /* Maximum width */
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        .login-box h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .login-box input[type="text"],
        .login-box input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            box-sizing: border-box;
            border-radius: 5px;
        }
        .login-box input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #5C6BC0;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .login-box input[type="submit"]:hover {
            background-color: #3F51B5;
        }

        /* Responsive adjustments */
        @media (max-width: 600px) {
            .login-box {
                width: 90%; /* Increase width on smaller screens */
                padding: 30px; /* Adjust padding */
            }
            .login-box h2 {
                font-size: 1.5em; /* Adjust font size */
            }
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Login</h2>
        <form method="post"> <!-- Form now posts to itself -->
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login" name="login">
        </form>
    </div>

<?php
if (isset($_POST['login'])) {
    // Database configuration
    $host = 'localhost'; // or your database host
    $dbname = 'usersign'; // your database name
    $db_username = 'root'; // your database username
    $db_password = ''; // your database password

    // Create connection
    $conn = new mysqli($host, $db_username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute query
    $stmt = $conn->prepare("SELECT password FROM usersign WHERE username = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $username);

    // Set parameter and execute
    $username = $_POST['username'];
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($_POST['password'], $row['password'])) {
            // Redirect to navigation.html
            header("Location: navigation.html");
            exit; // Always call exit after header redirection
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Username does not exist.";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>


</body>
 <script>
        function validateForm() {
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;

            if (username == "user" && password == "pass") {
                alert("Login successful!");
              header("Location: navigation.html");
            } else {
                alert("Invalid username or password");
                return false;
            }
        }
    </script>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Signup Page</title>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .signup-box {
            width: 300px;
            padding: 20px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }
        .signup-box h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .signup-box input[type="text"],
        .signup-box input[type="email"],
        .signup-box input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }
        .signup-box input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
        }
        .signup-box input[type="submit"]:hover {
            background-color: #444;
        }
    </style>
</head>
<body>
    <div class="signup-box">
        <h2>Signup</h2>
        <form action="Singup.php" method="post">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="submit" value="Sign Up">
</form>
    </div>
</body>
</html>

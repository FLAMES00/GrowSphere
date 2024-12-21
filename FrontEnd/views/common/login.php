<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url("../assets/back.jpg");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Helvetica, sans-serif;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.8);
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
        }

        .login-container h1 {
            text-align: center;
            font-size: 1.8rem;
            margin-bottom: 1rem;
            color: #333;
        }

        .form-control {
            height: calc(1.5em + 1.25rem + 2px);
        }

        .b {
            width: 100%;
            font-weight: bold;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .forgot-password {
            text-align: center;
            margin-top: 1rem;
        }

        .forgot-password a {
            text-decoration: none;
            color: #0d6efd;
        }

        @media (max-width: 768px) {
            .login-container {
                padding: 30px 20px;
            }

            body {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <form method="POST" action="login.php">
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="username" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <input type="submit" value="Login" class="btn btn-primary" name="login_Btn">
            <a href="./signup.html"><button type="button" class="btn btn-secondary">Sign Up</button></a>
            <div class="forgot-password">
                <a href="#">Forgot Password?</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "webpage");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['login_Btn'])) {
    // Sanitize user input to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Prepared statement to prevent SQL injection
    $sql = "SELECT * FROM logindata WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Check if the username exists and if password matches
        if ($row = mysqli_fetch_assoc($result)) {
            $resultPassword = $row['password'];

            // Verify password (you should use hashed passwords in production)
            if ($password === $resultPassword) {
                header('Location: views/hi.html');
                exit();
            } else {
                echo "<script>alert('Login unsuccessful. Incorrect password.');</script>";
            }
        } else {
            echo "<script>alert('Login unsuccessful. Username not found.');</script>";
        }

        // Close statement and connection
        mysqli_stmt_close($stmt);
    }
}

// Close the database connection
mysqli_close($conn);
?>

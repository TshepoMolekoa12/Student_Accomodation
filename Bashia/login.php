<?php
session_start();
include 'db_connection.php';

$message = '';
$alertType = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input and trim any unwanted spaces
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format!";
        $alertType = "error";
    } else {
        // Check if user exists
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $username, $hashed_password);
            $stmt->fetch();

            // Verify password
            if (password_verify($password, $hashed_password)) {
                // Store user session data
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $username; 
                $_SESSION['email'] = $email;
                
                // Success message
                $message = "Login successfully! Redirecting...";
                $alertType = "success";
            } else {
                // Invalid password
                $message = "Invalid email or password!";
                $alertType = "error";
            }
        } else {
            // User not found
            $message = "User not found!";
            $alertType = "error";
        }

        $stmt->close();
    }
    
    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('uploads/logo.jpg');
            background-size: cover;
            background-position: center;
        }
        .card {
            max-width: 350px;
            width: 100%;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            background: #fff;
        }
    </style>
</head>
<body>
    <div class="card">
        <h3 class="text-center text-primary">User Login</h3>
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input type="email" name="email" placeholder="Enter email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password:</label>
                <input type="password" name="password" placeholder="Enter password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <div class="text-center mt-3">
            <a href="forgot_password.php" class="text-danger">Forgot Password?</a>
        </div>
        <div class="text-center mt-3">
            <a href="home.php" class="btn btn-outline-secondary btn-sm">Back to Home</a>
            <a href="register.php" class="btn btn-outline-success btn-sm">Register</a>
        </div>
    </div>

    <script>
        <?php if (!empty($message)) : ?>
            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: "toast-top-right",
                timeOut: "3000"
            };
            toastr.<?php echo $alertType; ?>("<?php echo $message; ?>");

            <?php if ($alertType == "success") : ?>
                setTimeout(() => {
                    window.location.href = "user_dashboard.php";
                }, 2000);
            <?php endif; ?>
        <?php endif; ?>
    </script>
</body>
</html>

<!-- User Registration Page -->
<?php
session_start();
include 'db_connection.php';

$message = '';
$alertType = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';

    // Password validation
    if (strlen($password) < 6) {
        $message = "Password must be at least 6 characters long.";
        $alertType = "error";
    } elseif ($password !== $confirm_password) {
        $message = "Passwords do not match!";
        $alertType = "error";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if username or email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message = "Username or Email already exists!";
            $alertType = "error";
        } else {
            $stmt->close();

            // Insert new user
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);
            if ($stmt->execute()) {
                $message = "Registration successful!";
                $alertType = "success";
            }
            $stmt->close();
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            max-width: 400px;
            width: 100%;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            background: #fff;
        }

    .form-links {
    text-align: center;
    margin-top: 15px;
    font-size: 14px;
}

.form-links a {
    text-decoration: none;
    font-weight: 600;
    color: #007bff;
    transition: color 0.3s ease-in-out;
}

.form-links a:hover {
    color: #0056b3;
    text-decoration: none;
}
    </style>
</head>
<body>

    <div class="card">
        <h3 class="text-center text-primary">User Registration</h3>
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Enter username" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>

        <!-- Links to home and login -->
        <div class="form-links">
            <a href="home.php">Back to Home</a> | 
            <a href="login.php">Already have an account?Login</a>
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
        <?php endif; ?>
    </script>
    
</body>
</html>

<?php
include 'db_connection.php';

$message = '';
$alertType = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    // Check if user exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $token = bin2hex(random_bytes(32)); // Generate unique token
        $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Save token in the database
        $stmt = $conn->prepare("INSERT INTO password_resets (email, token, expires) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $token, $expires);
        $stmt->execute();
        $stmt->close();

        // Send email (Replace with actual mailer logic)
        $reset_link = "http://localhost/Bashia/reset_password.php?token=" . $token;
        mail($email, "Password Reset", "Click this link to reset your password: $reset_link");

        $message = "Password reset link sent!";
        $alertType = "success";
    } else {
        $message = "Email not found!";
        $alertType = "error";
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
            background-color: #f8f9fa;
            margin: 0;
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
        <h3 class="text-center text-primary">Forgot Password</h3>
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" placeholder="Enter email" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
        </form>
        <div class="text-center mt-3">
            <a href="login.php" class="btn btn-outline-secondary btn-sm">Back to Login</a>
        </div>
    </div>

    <script>
        <?php if (!empty($message)) : ?>
            toastr.<?php echo $alertType; ?>("<?php echo $message; ?>");
        <?php endif; ?>
    </script>
</body>
</html>

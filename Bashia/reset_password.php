<?php
session_start();
include 'db_connection.php';

$message = "";
$alertType = "";
$token = isset($_GET['token']) ? $_GET['token'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (strlen($new_password) < 6) {
        $message = "Password must be at least 6 characters long.";
        $alertType = "error";
    } elseif ($new_password !== $confirm_password) {
        $message = "Passwords do not match!";
        $alertType = "error";
    } else {
        // Check if token is valid and not expired
        $stmt = $conn->prepare("SELECT id FROM users WHERE reset_token = ? AND token_expiry > NOW()");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Update password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, token_expiry = NULL WHERE reset_token = ?");
            $stmt->bind_param("ss", $hashed_password, $token);
            $stmt->execute();

            $message = "Password reset successful! You can now login.";
            $alertType = "success";
        } else {
            $message = "Invalid or expired reset token.";
            $alertType = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <style>
        body { display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f8f9fa; }
        .card{
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
}

.form-links a {
    text-decoration: none;
    font-weight: bold;
    color: #007bff;
    padding: 8px 15px;
    border-radius: 5px;
    transition: all 0.3s ease-in-out;
    display: inline-block;
}

.form-links a:hover {
    text-decoration: none;
    background-color: #007bff;
    color: white;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

    </style>
</head>
<body>
    <div class="card">
        <h3 class="text-center text-primary">Set New Password</h3>
        <form method="POST" action="">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input type="password" name="new_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Reset Password</button>
        </form>
        <div class="form-links">
    <a href="login.php">← Back to Login</a>
</div>

    </div>

    <script>
        <?php if (!empty($message)) : ?>
            toastr.options = { closeButton: true, progressBar: true, positionClass: "toast-top-right", timeOut: "3000" };
            toastr.<?php echo $alertType; ?>("<?php echo $message; ?>");
        <?php endif; ?>
    </script>
</body>
</html>

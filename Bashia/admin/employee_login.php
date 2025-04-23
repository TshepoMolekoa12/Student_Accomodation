<?php
session_start();
include '../db_connection.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate email and password inputs
    if (empty($email) || empty($password)) {
        $error = "Email and password are required!";
    } else {
        // Query to check the employee login
        $query = "SELECT id, name, password, position FROM employees WHERE email = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            die("Database error: " . $conn->error);
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            // Verify the password
            if (password_verify($password, $row['password'])) {
                // Set session variables
                $_SESSION['employee_id'] = $row['id'];
                $_SESSION['employee_name'] = $row['name'];
                $_SESSION['employee_position'] = $row['position'];

                // Role-based redirection
                switch ($row['position']) {
                    case 'Admin':
                        header("Location: employee_dashboard.php");
                        break;
                    case 'Manager':
                        header("Location: manager_dashboard.php");
                        break;
                    case 'Finance':
                        header("Location: finance_dashboard.php");
                        break;
                    case 'Maintenance':
                        header("Location: maintenance_dashboard.php");
                        break;
                    default:
                        header("Location: employee_dashboard.php"); // Default dashboard
                }
                exit();
            } else {
                $error = "Invalid email or password!";
            }
        } else {
            $error = "Invalid email or password!";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('../uploads/logo.jpg');
            background-size: cover;
            background-position: center;
        }
        .card {
            width: 350px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            background-color: white;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="card">
        <h3 class="text-center">Employee Login</h3>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</body>
</html>
<?php
include '../db_connection.php';
session_start();

if (!isset($_SESSION['employee_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['employee_id'];

// Fetch properties
$sql = "SELECT p.id, p.name, p.location, p.rental_price, p.description, p.image, p.available_rooms 
        FROM properties p";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

$stmt->execute();
$result = $stmt->get_result();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    
    <style>
        .wrapper {
            display: flex;
            min-height: 100vh;
            background: #eef1f7;
            font-family: 'Poppins', sans-serif;
        }
        #sidebar {
            background: #2c3e50;
            color: white;
            height: 100vh;
            width: 250px;
            transition: all 0.3s ease;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.5);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        .main-content {
            flex-grow: 1;
            padding: 40px;
            margin-left: 250px;
            transition: margin-left 0.3s ease;
        }
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            padding: 25px;
            text-align: center;
        }
        .btn {
            border-radius: 10px;
            font-weight: bold;
            transition: all 0.3s ease;
            padding: 12px 20px;
            font-size: 1rem;
        }
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.25);
        }
        .toggle-btn {
            background: #ecf0f1;
            border-radius: 5px;
            padding: 6px 12px;
            border: none;
            cursor: pointer;
            display: none;
        }
        .toggle-btn:hover {
            background: #bdc3c7;
        }
        @media (max-width: 768px) {
            .toggle-btn {
                display: block;
            }
            .main-content {
                margin-left: 0;
            }
            #sidebar {
                margin-left: -250px;
            }
        }
    </style>
</head>
<body>
<div class="wrapper">
    <?php include 'sidebar_manager.php'; ?>
    
    <div class="main-content">
        <button class="toggle-btn d-md-none" id="menuToggle" onclick="toggleSidebar()">
            <i class="bi bi-list"></i> Menu
        </button>
        <div class="card shadow-lg p-4">
            <h2 class="mb-4 text-primary">Welcome!</h2>
            <p class="mb-4 text-muted">Edit and Update your property details.</p>
            <div class="d-flex flex-wrap justify-content-center gap-4">
            <a href="manage_employees.php" class="nav-link"><i class="bi bi-people"></i> Employees</a>
            <a href="manage_properties.php" class="nav-link"><i class="bi bi-building"></i> Properties</a>
            <a href="manage_tenants.php" class="nav-link"><i class="bi bi-person"></i> Tenants</a>
            <a href="task_assignments.php" class="nav-link"><i class="bi bi-clipboard-check"></i> Task Assignments</a>
            <a href="reports_analytics.php" class="nav-link"><i class="bi bi-bar-chart"></i> Reports & Analytics</a>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleSidebar() {
        var sidebar = document.getElementById("sidebar");
        var mainContent = document.querySelector(".main-content");
        var toggleBtn = document.getElementById("menuToggle");
        
        if (sidebar.style.marginLeft === "0px" || sidebar.style.marginLeft === "") {
            sidebar.style.marginLeft = "-250px";
            mainContent.style.marginLeft = "0px";
            toggleBtn.style.display = "block";
        } else {
            sidebar.style.marginLeft = "0px";
            mainContent.style.marginLeft = "250px";
            toggleBtn.style.display = "none";
        }
    }
</script>


</body>
</html>

<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT b.id, p.name, p.rental_price, b.booking_date, b.payment_method, b.status
        FROM bookings b
        JOIN properties p ON b.property_id = p.id
        WHERE b.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
            overflow-x: hidden; /* Prevent horizontal scrolling */
        }
        .wrapper {
            display: flex;
            min-height: 100vh; /* Ensure the sidebar reaches the full height */
        }
        #sidebar {
            background: #2c3e50;
            color: white;
            width: 250px;
            padding: 20px;
            position: fixed; /* Fixed position to keep it in view */
            top: 0;
            left: 0;
            height: 100%; /* Full height */
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.5);
        }
        .content {
            margin-left: 250px; /* Leave space for the sidebar */
            display: flex;
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            flex-direction: column; /* Stack items vertically */
            padding: 30px;
            width: 100%; /* Full width */
        }
        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 800px; /* Max width for the container */
            width: 100%; /* Full width for responsiveness */
        }
        h2 {
            color: #007bff;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            margin-top: 20px;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        td {
            vertical-align: middle;
        }
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <?php include 'sidebar.php'; ?>
        <div class="content">
            <div class="container">
                <h2>My Bookings</h2>
                <?php if ($result->num_rows > 0) { ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Property Name</th>
                                <th>Rental Price</th>
                                <th>Booking Date</th>
                                <th>Payment Method</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['name']) ?></td>
                                    <td>R<?= number_format($row['rental_price'], 2) ?></td>
                                    <td><?= htmlspecialchars($row['booking_date']) ?></td>
                                    <td><?= htmlspecialchars($row['payment_method']) ?></td>
                                    <td><?= htmlspecialchars($row['status']) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <div class="alert alert-info" role="alert">
                        You have not made any bookings yet.
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Check if there are no bookings and show SweetAlert
        const noBookingsDiv = document.querySelector('.alert-info');
        if (noBookingsDiv) {
            Swal.fire({
                title: 'No Bookings Found',
                text: 'You have not made any bookings yet.',
                icon: 'info',
                confirmButtonText: 'Okay'
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
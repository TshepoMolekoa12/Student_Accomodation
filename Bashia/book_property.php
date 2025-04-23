<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ensure 'id' is set in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: Property ID is missing.");
}

$user_id = $_SESSION['user_id'];
$property_id = $_GET['id'];

// Fetch property details
$sql = "SELECT name, rental_price, description, image FROM properties WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $property_id);
$stmt->execute();
$result = $stmt->get_result();
$property = $result->fetch_assoc();

if (!$property) {
    die("Error: Property not found.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $proof_of_payment = $_FILES['proof_of_payment']['name'];

    // Handle file upload
    if (!empty($proof_of_payment)) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($proof_of_payment);
        move_uploaded_file($_FILES['proof_of_payment']['tmp_name'], $target_file);
    }

    $sql = "INSERT INTO bookings (user_id, property_id, proof_of_payment, status) VALUES (?, ?, ?, 'Pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $user_id, $property_id, $proof_of_payment);
    if ($stmt->execute()) {
        header("Location: my_bookings.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error booking the property.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Property</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .wrapper {
            display: flex;
            min-height: 100vh;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #007bff;
            margin-bottom: 20px;
        }
        .property-image {
            width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            transition: background-color 0.3s;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <?php include 'sidebar.php'; ?>
    
    <div class="container">
        <button class="toggle-btn d-md-none" id="menuToggle" onclick="toggleSidebar()">
            <i class="bi bi-list"></i> Menu
        </button>
        <h2>Booking for <?= htmlspecialchars($property['name']) ?></h2>
        <img src="uploads/<?= htmlspecialchars($property['image']) ?>" alt="Property Image" class="property-image">
        <p><strong>Rental Price:</strong> R<?= number_format($property['rental_price'], 2) ?> / month</p>
        <p><strong>Description:</strong> <?= htmlspecialchars($property['description']) ?></p>
        
        <br>
        <h4>Banking Details</h4>
        <div class="mb-3">
            <p><strong>Bank:</strong> ABSA Bank</p>
            <p><strong>Account Number:</strong> 530 861 945</p>
 <p><strong>Branch Code:</strong> 632 005</p>
            <p><strong>Reference:</strong> Your ID number or passport number</p>
            <p><strong>Application Amount:</strong> R100.00</p>
        </div>
        
        <br>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="proof_of_payment" class="form-label">Upload Proof of Payment:</label>
                <input type="file" name="proof_of_payment" id="proof_of_payment" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
            </div>
            
            <button type="button" class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#termsModal">View Terms and Conditions</button>
            <button type="submit" class="btn btn-primary w-100 mt-3">Confirm Booking</button>
        </form>
    </div>
</div>

<!-- Terms and Conditions Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>1. Payment Terms</h6>
                <p>All payments must be made in full before the booking is confirmed.</p>
                <h6>2. Refund Policy</h6>
                <p>Refunds will only be issued under specific circumstances as outlined in our policy.</p>
                <h6>3. Liability</h6>
                <p>We are not liable for any damages or losses incurred during your stay.</p>
                <h6>4. Changes to Terms</h6>
                <p>We reserve the right to change these terms at any time. Please check back regularly for updates.</p>
                <!-- Add more terms as needed -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
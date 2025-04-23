
<?php
include 'db_connection.php';
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch properties
$sql = "SELECT p.id, p.name, p.location, p.rental_price, p.description, p.image, p.available_rooms 
        FROM properties p";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// Check if there are any available rentals
$hasAvailableRentals = false;
while ($row = $result->fetch_assoc()) {
    if ($row['available_rooms'] > 0) {
        $hasAvailableRentals = true;
        break;
    }
}

// Reset the result pointer to the beginning
$stmt->execute();
$result->data_seek(0); // Reset the result set pointer
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .wrapper {
            display: flex;
            min-height: 100vh;
            background: #eef1f7;
            transition: margin-left 0.3s ease;
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
            margin-left: 250px; /* Default margin for larger screens */
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
            display: none; /* Hidden by default */
        }
        .toggle-btn:hover {
            background: #bdc3c7;
        }
        @media (max-width: 768px) {
            .toggle-btn {
                display: block; /* Show toggle button on small screens */
            }
            .main-content {
                margin-left: 0; /* No margin for small screens */
            }
            #sidebar {
                margin-left: -250px; /* Hide sidebar */
            }
            #sidebar.active {
                margin-left: 0; /* Show sidebar when active */
            }
        }
        h2 {
            font-weight: 600;
            color: #007bff;
            text-align: center;
        }
        /* Property Cards */
        .property-card {
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            background: white;
            padding: 15px;
        }
        .property-card:hover {
            transform: scale(1.03);
            box-shadow: 0px 6px 14px rgba(0, 0, 0, 0.15);
        }
        .property-img {
            width : 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }
        .property-title {
            font-size: 18px;
            font-weight: 600;
            margin-top: 10px;
        }
        .property-price {
            font-size: 16px;
            font-weight: 500;
            color: #28a745;
        }
        .property-desc {
            font-size: 14px;
            color: #666;
        }
        .fully-occupied-message {
            text-align: center;
            font-size: 18px;
            color: #dc3545;
            margin-top: 20px;
        }
        .modal-content {
            border-radius: 15px; /* Rounded corners */
            padding: 20px; /* Padding inside the modal */
            border: none; /* Remove border */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Add shadow for depth */
        }
        .modal-header {
            border-bottom: none; /* Remove bottom border */
        }
        .modal-title {
            font-weight: bold; /* Make title bold */
            color: #007bff; /* Change title color */
        }
        .modal-body {
            padding: 20px; /* Add padding to the body */
        }
        .modal-footer {
            border-top: none; /* Remove top border */
            padding: 10px; /* Add padding to footer */
        }
        .modal-footer .btn {
            padding: 10px 15px; /* Adjust button padding */
            font-size: 16px; /* Increase font size */
            border-radius: 5px; /* Rounded corners for buttons */
        }
        .modal-footer .btn-secondary {
            background-color: #6c757d; /* Secondary button color */
            border: none; /* Remove border */
        }
        .modal-footer .btn-secondary:hover {
            background-color: #5a6268; /* Darker on hover */
        }
        .modal-footer .btn-success {
            background-color: #28a745; /* Success button color */
            border: none; /* Remove border */
        }
        .modal-footer .btn-success:hover {
            background-color: #218838; /* Darker on hover */
        }
    </style>
</head>
<body>

<div class="wrapper">
    <?php include 'sidebar.php'; ?>
    <div class="main-content">
        <button class="toggle-btn d-md-none" id="menuToggle" onclick="toggleSidebar()">
            <i class="bi bi-list"></i> Menu
        </button>
        
        <h2 class="mb-4 text-center">Available Rentals</h2>
        <?php if (!$hasAvailableRentals) { ?>
            <div class="fully-occupied-message">The accommodation is fully occupied.</div>
        <?php } else { ?>
            <div class="row">
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <div class="col-md-4 mb-4">
                        <div class="card property-card">
                            <img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="Property Image" class="property-img">
                            <?php if ($row['available_rooms'] == 0) { ?>
                                <div class="booked-overlay">BOOKED</div>
                            <?php } ?>
                            <div class="card-body">
                                <h5 class="property-title"><?= htmlspecialchars($row['name']) ?></h5>
                                <p class="property-price">R<?= number_format($row['rental_price'], 2) ?> / month</p>
                                <p class="property-desc"><?= substr(htmlspecialchars($row['description']), 0, 100) ?>...</p>
                                <button class="btn btn-primary w-100 view-details-btn" 
                                    data-bs-toggle="modal" data-bs-target="#propertyDetailsModal"
                                    data-id="<?= $row['id'] ?>" 
                                    data-name="<?= htmlspecialchars($row['name']) ?>" 
                                    data-location="<?= htmlspecialchars($row['location']) ?>" 
                                    data-price="<?= number_format($row['rental_price'], 2) ?>" 
                                    data-description="<?= htmlspecialchars($row['description']) ?>" 
                                    data-image="uploads/<?= htmlspecialchars($row['image']) ?>" 
                                    data-available="<?= $row['available_rooms'] ?>">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>

<!-- Property Details Modal -->
<div class="modal fade" id="propertyDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="propertyModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="propertyModalImage" src="" class="img-fluid rounded mb-3" alt="Property Image">
                <p><strong>Location:</strong> <span id="propertyModalLocation"></span></p>
                <p><strong>Price:</strong> R<span id="propertyModalPrice"></span> / month</p>
                <p id="propertyModalDescription"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a id="bookNowBtn" class="btn btn-success" style="display: none;">Book Now</a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".view-details-btn").forEach(button => {
        button.addEventListener("click", function () {
            document.getElementById("propertyModalTitle").innerText = this.dataset.name;
            document.getElementById("propertyModalImage").src = this.dataset.image;
            document.getElementById("propertyModalLocation").innerText = this.dataset.location;
            document.getElementById("propertyModalPrice").innerText = this.dataset.price;
            document.getElementById("propertyModalDescription").innerText = this.dataset.description;
            
            let bookBtn = document.getElementById("bookNowBtn");
            bookBtn.href = `book_property.php?id=${this.dataset.id}`;
            
            // Show or hide the "Book Now" button based on availability
            if (this.dataset.available == 0) {
                bookBtn.style.display = "none"; // Hide if not available
            } else {
                bookBtn.style.display = "block"; // Show if available
            }

            let propertyModal = new bootstrap.Modal(document.getElementById('propertyDetailsModal'));
            propertyModal.show();
        });
    });
});


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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
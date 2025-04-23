<?php
include 'navbar.php';   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Team - Student Accommodation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        /* Page Styling */
        body {
            background-color: #f8f9fa;
            color: #333;
        }

        /* Team Section */
        .team-section {
            padding: 50px 20px;
            text-align: center;
        }
        .team-member {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            margin: 20px;
            height: 350px; /* Fixed height for uniformity */
            display: flex;
            flex-direction: column; /* Stack elements vertically */
            justify-content: space-between; /* Space between elements */
            align-items: center; /* Center items horizontally */
        }
        .team-member:hover {
            transform: translateY(-5px); /* Elevate on hover */
        }
        .team-member img {
            width: 150px; /* Fixed width */
            height: 150px; /* Fixed height */
            border-radius: 10px; /* Rounded corners */
            object-fit: cover; /* Maintain aspect ratio */
            margin-bottom: 15px;
        }
        .team-member h4 {
            margin: 10px 0;
        }
        .team-member p {
            font-size: 0.9rem;
            color: #555;
            flex-grow: 1; /* Allow the paragraph to grow and take available space */
        }

        /* Additional Information */
        .info {
            font-size: 0.9rem;
            color: #007bff; /* Bootstrap primary color */
            margin-top: 10px;
        }
        .info a {
            text-decoration: none; /* Remove underline */
        }
        .info a:hover {
            text-decoration: underline; /* Underline on hover */
        }

        /* Scroll Animation */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 1s ease-out, transform 1s ease-out;
        }
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>
    
    <!-- Team Section -->
    <div class="container team-section">
        <h2 class="fade-in">Meet Our Team</h2>
        <p class="fade-in">Dedicated professionals committed to providing the best student accommodation experience.</p>
        <div class="row">
            <div class="col-md-4 col-sm-12 fade-in">
                <div class="team-member">
                    <img src="uploads/CEO.jpg" alt="John Doe">
                    <h4>...</h4>
                    <p>(role)</p>
                    <p>.... has over 10 years of experience in the accommodation industry and is passionate about creating a supportive environment for students.</p>
                    <div class="info"><a href="mailto:john@example.com">Email: john@example.com</a></div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 fade-in">
                <div class="team-member">
                    <img src="uploads/CEO.jpg" alt="Jane Smith">
                    <h4>...</h4>
                    <p>(role)</p>
                    <p>... oversees the daily operations and ensures that everything runs smoothly for our residents.</p>
                    <div class="info"><a href="mailto:jane@example.com">Email: jane@example.com</a></div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 fade-in">
                <div class="team-member">
                    <img src="uploads/CEO.jpg" alt="Michael Brown">
                    <h4>....</h4>
                    <p>(Role)</p>
                    <p>... is dedicated to providing excellent customer service and is always available to assist students with their needs.</p>
                    <div class="info"><a href="mailto:michael@example.com">Email: michael@example.com</a></div>
                </div>
            </div>
        </div>
    </div>

    <?php 
    include 'footer.php'; 
    ?>

    <script>
        // Fade-in effect for all elements
        function fadeInElements() {
            document.querySelectorAll('.fade-in').forEach((el, i) => {
                setTimeout(() => {
                    el.classList.add('visible');
                }, i * 500);
            });
        }

        // Start animations on page load
        window.onload = function () {
            fadeInElements(); // Animate elements in the team section
        };
    </script>

</body>
</html>
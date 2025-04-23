<?php
include 'navbar.php';   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Mission - Student Accommodation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        /* Hero Section */
        .hero {
            background: url('uploads/mmisss.jpg') no-repeat center center/cover; /* Use background image */
            height: 100vh; /* Full viewport height */
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            flex-direction: column;
            padding: 20px;
            color: black;
        }
        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
            max-width: 90%;
        }
        .hero p {
            font-size: 1.2rem;
            max-width: 90%;
        }

        /* Mission Section */
        .mission-section {
            padding: 20px;
            text-align: center;
            background-color: #f8f9fa;
        }
        .mission-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            margin: 20px auto;
            max-width: 600px; /* Adjusted max width */
        }
        .mission-card:hover {
            transform: translateY(-5px); /* Elevate on hover */
        }
        .mission-card h2 {
            font-size: 2rem; /* Adjusted font size */
            margin-bottom: 10px;
        }
        .mission-card p {
            font-size: 1rem; /* Adjusted font size */
            line-height: 1.5;
        }

        /* Icons Section */
        .icon-section {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            flex-wrap: wrap; /* Allow wrapping for smaller screens */
        }
        .icon-box {
            text-align: center;
            margin: 10px; /* Adjusted margin */
            flex: 1 1 150px; /* Flexbox for responsive layout */
        }
        .icon-box i {
            font-size: 2.5rem; /* Adjusted icon size */
            color: #f8c146;
            margin-bottom: 10px;
        }

        /* Call to Action */
        .cta {
            background-color: #f8c146;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .cta h3 {
            margin: 0;
        }
        .cta a {
            color: white;
            font-weight: bold;
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
    
    <!-- Hero Section -->
    <div class="hero">
        <h1 class="fade-in">Our Mission</h1>
        <p class="fade-in">To provide a safe, comfortable, and supportive living environment for students, fostering academic success and personal growth.</p>
    </div>

    <!-- Mission Section -->
    <div class="container mission-section">
        <div class="mission-card fade-in">
            <h2>Our Commitment</h2>
            <p>At (...) Student Accommodation, we are dedicated to creating a community where students can thrive. Our mission is to offer modern, secure, and affordable housing that meets the diverse needs of our residents.</p>
        </div>

        <!-- Icons Section -->
        <div class="icon-section">
            <div class="icon-box fade-in">
                <i class="fas fa-users"></i>
                <h5>Community</h5>
                <p>Building a supportive community for all students.</p>
            </div>
            <div class="icon-box fade-in">
                <i class="fas fa-shield-alt"></i>
                <h5>Safety</h5>
                <p>Ensuring a safe and secure living environment.</p>
            </div>
            <div class="icon-box fade-in">
                <i class="fas fa-dollar-sign"></i>
                <h5>Affordability</h5>
                <p>Providing affordable housing options for every budget.</p>
            </div>
        </div>

        <div class="cta fade-in">
            <h3>Join Us in Our Mission!</h3>
            <p>Ready to find your new home? <a href="register.php">Apply Now</a></p>
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
            fadeInElements(); // Animate elements in the hero section
        };
    </script>

</body>
</html>
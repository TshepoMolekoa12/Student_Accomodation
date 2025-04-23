<?php
include 'navbar.php';   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Living</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"> <!-- Font Awesome -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        /* Page Styling */
        body {
            background-color: #f8f9fa; /* Light background */
            color: #333; /* Dark text */
        }

        /* Header Section */
        .header-section {
            padding: 50px 20px;
            text-align: center;
            background-image: url('uploads/acc.jpeg'); /* Background image */
            background-size: cover;
            background-position: center;
            color: rgb(40, 62, 85);
        }
        .header-section h1 {
            font-size: 2.5rem;
            font-weight: bold;
        }
        .header-section p {
            font-size: 1.2rem;
        }

        /* Benefits, Amenities, Community, FAQs */
        .section {
            padding: 50px 20px;
        }
        .benefit-item, .amenity-item, .faq-item {
            margin-bottom: 20px;
            text-align: center;
            opacity: 0; /* Start hidden */
            transform: translateY(20px); /* Start slightly below */
            transition: opacity 0.5s ease-out, transform 0.5s ease-out; /* Smooth transition */
        }
        .benefit-item h4, .amenity-item h4 {
            font-weight: bold;
            color: rgb(165, 153, 50); /* Primary color */
        }
        .benefit-item i, .amenity-item i {
            font-size: 2rem; /* Icon size */
            color: rgb(165, 163, 68); /* Icon color */
            margin-bottom: 10px; /* Space between icon and text */
        }
        .call-to-action {
            text-align: center;
            padding: 30px 20px;
            background-color: #f8c146; /* Soft yellow */
            color: #333;
        }
    </style>
</head>
<body>
    
    <!-- Header Section -->
    <div class="header-section">
        <h1>Student Living</h1>
        <p>Experience a vibrant and supportive community.</p>
    </div>

    <!-- Benefits Section -->
    <div class="container section">
        <h2 class="text-center">Benefits of Student Living</h2>
        <div class="row">
            <div class="col-md-4 benefit-item fade-in">
                <i class="fas fa-users"></i>
                <h4>Community</h4>
                <p>Join a diverse community of students and make lifelong friends. Engage in group activities and build connections that last beyond your studies.</p>
            </div>
            <div class="col-md-4 benefit-item fade-in">
                <i class="fas fa-user-graduate"></i>
                <h4>Support</h4>
                <p>Access to support services, including academic advising and mental health resources, ensuring you have the help you need to succeed.</p>
            </div>
            <div class="col-md-4 benefit-item fade-in">
                <i class="fas fa-map-marker-alt"></i>
                <h4>Convenience</h4>
                <p>Located close to campus and local amenities, making it easy to access classes, shops, and dining options.</p>
            </div>
        </div>
    </div>

    <!-- Amenities Section -->
    <div class="container section">
        <h2 class="text-center">Amenities</h2>
        <div class="row">
            <div class="col-md-4 amenity-item fade-in">
                <i class="fas fa-wifi"></i>
                <h4>High-Speed Wi-Fi</h4>
                <p>Stay connected with fast and reliable internet throughout the accommodation, perfect for studying and streaming.</p>
            </div>
            <div class="col-md-4 amenity-item fade-in">
                <i class="fas fa-book-open"></i>
                <h4>Study Areas</h4>
                <p>Quiet and comfortable study spaces equipped with power outlets and comfortable seating to help you focus on your studies.</p>
            </div>
            <div class="col-md-4 amenity-item fade-in">
                <i class="fas fa-utensils"></i>
                <h4>Kitchen Facilities</h4>
                <p>Prepare your own meals in our fully equipped kitchens, complete with appliances and cookware for your convenience.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 amenity-item fade-in">
                <i class="fas fa-users-cog"></i>
                <h4>Common Rooms</h4>
                <p>Relax and socialize in our common rooms, equipped with games, TVs, and comfortable seating.</p>
            </div>
            <div class="col-md-4 amenity-item fade-in">
                <i class="fas fa-shield-alt"></i>
                <h4>24/7 Security</h4>
                <p>Your safety is our priority. Enjoy peace of mind with 24/7 security and surveillance throughout the property.</p>
            </div>
            <div class="col-md-4 amenity-item fade-in">
                <i class="fa fa-shower" aria-hidden="true"></i>
                <h4>Shower</h4>
                <p>Clean and hot water available 24/7.</p>
            </div>
        </div>
    </div>

    <!-- Community and Events Section -->
    <div class="container section">
        <h2 class="text-center">Community and Events</h2>
        <p class="text-center">Participate in various social events, workshops, and activities designed to enhance your student experience and foster connections. From movie nights to study groups, there’s always something happening!</p>
    </div>

    <!-- Call to Action Section -->
    <div class="call-to-action">
        <h2>Ready to Join Us?</h2>
        <p>Apply now to secure your spot!</p>
        <a href="register.php" class="btn btn-primary">Apply Now</a>
    </div>

    <?php 
    include 'footer.php'; 
    ?>

    <script>
        // Function to check if an element is in the viewport
        function isElementInViewport(el) {
            const rect = el.getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        }

        // Function to add the animation class
        function animateOnScroll() {
            const elements = document.querySelectorAll('.fade-in');
            elements.forEach((el) => {
                if (isElementInViewport(el)) {
                    el.style.opacity = 1; // Make visible
                    el.style.transform = 'translateY(0)'; // Move to original position
                }
            });
        }

        // Event listener for scroll
        window.addEventListener('scroll', animateOnScroll);
        // Initial check
        animateOnScroll();
    </script>

</body>
</html>
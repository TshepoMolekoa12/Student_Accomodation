<?php
include 'navbar.php';   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tshepo Student Accommodation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        /* Hero Section */
        .hero {
            background: url('uploads/acc.jpeg') no-repeat center center/cover;
            height: 80vh;
            color: black ;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            flex-direction: column;
            padding: 20px;
        }
        .hero h1, .hero p, .btn-primary {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 1s ease-out, transform 1s ease-out;
        }
        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
            max-width: 90%;
            text-align: center;
        }
        .hero p {
            font-size: 1.2rem;
            max-width: 90%;
        }
        .btn-primary {
            background-color: #f8c146;
            border: none;
            padding: 12px 30px;
            font-size: 1.2rem;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background-color: #e0a800;
            transform: scale(1.05);
        }

        /* Features Section */
        .features {
            padding: 50px 20px;
            text-align: center;
        }
        .feature-box {
            text-align: center;
            padding: 20px;
            transition: transform 0.3s ease;
        }
        .feature-box i {
            font-size: 3rem;
            color: #f8c146;
        }
        .feature-box:hover {
            transform: scale(1.05);
        }

        /* Testimonials */
        .testimonial {
            background: #f8f9fa;
            padding: 50px 20px;
            text-align: center;
        }
        .testimonial-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            margin-bottom: 20px;
            width: 300px; /* Set equal width */
            margin: 10px; /* Space between cards */
        }
        .testimonial-box:hover {
            transform: translateY(-5px);
        }

        /* Student Image */
        .testimonial-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }

        /* Star Rating */
        .star-rating {
            font-size: 18px;
            color: #f8c146; /* Gold */
            margin-bottom: 10px;
        }

        /* Room Types */
        .room-types {
            background: #f8f9fa;
            padding: 50px 0;
            text-align: center;
        }
        .room-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
        }

        /* Clickable Icon (Magnifying Glass) */
        .click-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            padding: 15px;
            border-radius: 50%;
            font-size: 24px;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s ease-in-out;
        }
        .click-icon:hover {
            background-color: rgba(0, 0, 0, 0.8);
            transform: translate(-50%, -50%) scale(1.1);
        }

        /* WhatsApp Icon */
        .whatsapp-icon {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #25D366;
            color: white;
            border-radius: 50%;
            padding: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s;
            font-size: 24px;
        }
        .whatsapp-icon:hover {
            background-color: #128C7E;
        }

        /* Location and Contact Section */
        .location-contact {
            padding: 50px 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .location {
            flex: 1;
            margin-right: 20px;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .contact-form {
            flex: 1;
            margin-left: 20px;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Form Styling */
        .form-control {
            margin-bottom: 15px;
        }

        /* Map Section */
        .map {
            margin-top: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
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
        .btn {
            color: black
            background-color:rgb(71, 68, 60);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .d-flex {
                flex-direction: column; /* Stack on smaller screens */
                align-items: center;
            }
        }
    </style>
</head>
<body>
    
    <!-- Hero Section -->
    <div class="hero">
        <h1 class="fade-in">Welcome to Molekoa Accommodation</h1>
        <p class="fade-in">Modern, secure, and affordable student living in the heart of Vanderbijlpark.</p>
        <a href="register.php" class="btn btn-primary fade-in">Apply Now</a>
    </div>
    
    <!-- Features Section -->
    <div class="container features">
        <div class="row">
            <div class="col-md-4 col-sm-12 feature-box fade-in">
                <i class="fas fa-wifi"></i>
                <h4>Free Wi-Fi</h4>
                <p>High-speed internet for all your study and entertainment needs.</p>
            </div>
            <div class="col-md-4 col-sm-12 feature-box fade-in">
                <i class="fas fa-shield-alt"></i>
                <h4>24/7 Security</h4>
                <p>Your safety is our priority with CCTV surveillance and security guards.</p>
            </div>
            <div class="col-md-4 col-sm-12 feature-box fade-in">
                <i class="fas fa-bed"></i>
                <h4>Fully Furnished</h4>
                <p>Comfortable, fully-equipped rooms for a hassle-free student life.</p>
            </div>
        </div>
    </div>

    <!-- Room Types Section -->
    <div class="container room-types">
        <h2 class="fade-in">Room Types</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="room-card position-relative fade-in">
                    <img src="uploads/r3.jpg" class="img-fluid" alt="Single Room">
                    <h4>Single Room</h4>
                    <p>Perfect for students who prefer privacy and a quiet study environment.</p>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#roomModal" class="click-icon">
                        <i class="fas fa-search"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="room-card position-relative fade-in">
                    <img src="uploads/r3.jpg" class="img-fluid" alt="Sharing Room">
                    <h4>Sharing Room</h4>
                    <p>An affordable option for students looking to share with a roommate.</p>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#roomModal2" class="click-icon">
                        <i class="fas fa-search"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials -->
    <div class="testimonial">
        <div class="container">
            <h2 class="text-center fade-in">What Our Students Say</h2>
            <div class="d-flex justify-content-center flex-wrap">
                <div class="testimonial-box fade-in">
                    <img src="uploads/CEO.jpg" alt="Thabo M." class="testimonial-img">
                    <h5>Thabo M.</h5>
                    <div class="star-rating">★★★★☆</div>
                    <p>"(your-company) is the best student accommodation I've ever stayed in. Great facilities and friendly staff!"</p>
                </div>
                <div class="testimonial-box fade-in">
                    <img src="uploads/CEO.jpg" alt="Lerato K." class="testimonial-img">
                    <h5>Lerato K.</h5>
                    <div class="star-rating">★★★★★</div>
                    <p>"The location is perfect, and the rooms are so cozy. Highly recommend!"</p>
                </div>
                <div class="testimonial-box fade-in">
                    <img src="uploads/CEO.jpg" alt="Kabelo D." class="testimonial-img">
                    <h5>Kabelo D.</h5>
                    <div class="star-rating">★★★★☆</div>
                    <p>"Security is top-notch, and the study environment is perfect for students."</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Location and Contact Section -->
    <div class="container location-contact">
        <div class="location fade-in">
            <h2>Location</h2>
            <p>22 James Chapman Street, Vanderbijlpark</p>
            <p>We are conveniently located near local amenities, making it easy for students to access everything they need.</p>
            <div class="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1 m3!1d3153.123456789012!2d26.123456789012!3d-26.123456789012!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1e9f1234567890ab%3A0x1234567890abcdef!2s22%20James%20Chapman%20Street%2C%20Vanderbijlpark!5e0!3m2!1sen!2sza!4v1234567890123" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
        <div class="contact-form fade-in">
            <h2>Contact Us</h2>
            <form>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Your Name" required>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Your Email" required>
                </div>
                <div class="form-group">
                    <textarea class="form-control" rows="4" placeholder="Your Message" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send Message</button>
            </form>
        </div>
    </div>

    <!-- WhatsApp Icon -->
    <a href="https://wa.me/+27685350927" class="whatsapp-icon" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Modal for single room -->
    <div class="modal fade" id="roomModal" tabindex="-1" aria-labelledby="roomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="roomModalLabel">Single Room Gallery</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="roomCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="uploads/r1.jpg" class="d-block w-100" alt="Room Image 1">
                            </div>
                            <div class="carousel-item">
                                <img src="uploads/r2.jpg" class="d-block w-100" alt="Room Image 2">
                            </div>
                            <div class="carousel-item">
                                <img src="uploads/r3.jpg" class="d-block w-100" alt="Room Image 3">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for sharing room -->
    <div class="modal fade" id="roomModal2" tabindex="-1" aria-labelledby="roomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="roomModalLabel">Sharing Room Gallery</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="roomCarousel2" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="uploads/r1.jpg" class="d-block w-100" alt="Room Image 1">
                            </div>
                            <div class="carousel-item">
                                <img src="uploads/r2.jpg" class="d-block w-100" alt="Room Image 2">
                            </div>
                            <div class="carousel-item">
                                <img src="uploads/r3.jpg " class="d-block w-100" alt="Room Image 3">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel2" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel2" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
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

        // Scroll animation for elements
        function handleScrollAnimation() {
            const elements = document.querySelectorAll('.fade-in');
            elements.forEach(el => {
                const rect = el.getBoundingClientRect();
                if (rect.top < window.innerHeight - 100) {
                    el.classList.add('visible');
                }
            });
        }

        // Start animations on page load and scroll
        window.onload = function () {
            fadeInElements(); // Animate elements in the hero section
            handleScrollAnimation(); // Check for elements already in view
        };

        window.addEventListener('scroll', handleScrollAnimation); // Check for elements coming into view on scroll
    </script>

</body>
</html>
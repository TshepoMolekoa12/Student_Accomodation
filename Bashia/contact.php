<?php
include 'navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    
    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        /* Full-page layout */
        html, body {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .contact-container {
            width: 100%;
            max-width: 600px;
            padding: 30px;
            background: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .form-control {
            border-radius: 8px;
        }

        .btn-primary {
            background-color: #343a40;
            border: none;
            border-radius: 8px;
            padding: 10px;
            width: 100%;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background-color: #212529;
            transform: scale(1.02);
        }

        /* Footer */
        .footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 15px 0;
        }

        /* Fix dropdown issue */
        .navbar .dropdown-menu {
            z-index: 1050 !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .contact-container {
                width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<!-- Main Content -->
<div class="container">
    <div class="contact-container">
        <h2 class="text-center text-primary">Contact Us</h2>
        <p class="text-center text-muted">We'd love to hear from you!</p>

        <form method="POST" action="process_contact.php">
            <div class="mb-3">
                <label class="form-label">Full Name:</label>
                <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email Address:</label>
                <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Subject:</label>
                <input type="text" name="subject" class="form-control" placeholder="Enter subject" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Message:</label>
                <textarea name="message" class="form-control" rows="5" placeholder="Enter your message" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send Message</button>
        </form>
    </div>
</div>

<!-- Footer -->
<div class="footer">
    <p>&copy; 2025 YourCompany. All Rights Reserved.</p>
    <p><i class="fas fa-phone"></i> +27 123 456 7890 | <i class="fas fa-envelope"></i> support@yourcompany.com</p>
</div>


</body>
</html>


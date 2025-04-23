<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="home.php">
            <img src="uploads/logo.jpg" alt="Company Logo">
        </a>

        <!-- Navbar Toggler for Mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav text-center">
                <li class="nav-item">
                    <a class="nav-link fade-in" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fade-in" href="living.php">Student Living</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fade-in" href="#" id="aboutDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        About Us
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="aboutDropdown">
                        <li><a class="dropdown-item" href="mission.php">Our Mission</a></li>
                        <li><a class="dropdown-item" href="team.php">Our Team</a></li>
                        <li><a class="dropdown-item" href="faqs.php">FAQs</a></li>
                    </ul>
                </li>
                <!-- Login Dropdown with Hover Effect -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fade-in" href="#" id="loginDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Login
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="loginDropdown">
                        <li><a class="dropdown-item" href="login.php"><i class="fas fa-user"></i> User Login</a></li>
                        <li><a class="dropdown-item" href="admin/employee_login.php"><i class="fas fa-briefcase"></i> Employee Login</a></li>
                    </ul>
                </li>

                <!-- Register Link -->
                <li class="nav-item">
                    <a class="nav-link fade-in" href="register.php">Apply Now</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Navbar Styling -->
<style>
    /* Navbar Styling */
    .navbar {
        background-color: #343a40;
        padding: 8px 15px;
    }

    .navbar-brand img {
        height: 40px;
        width: auto;
    }

    .navbar-nav .nav-link {
        color: white !important;
        font-size: 14px;
        padding: 5px 12px;
        transition: 0.3s;
        opacity: 0; /* Start hidden */
        transform: translateY(-10px); /* Start slightly above */
        transition: opacity 0.5s ease-out, transform 0.5s ease-out; /* Smooth transition */
    }

    .navbar-nav .nav-link.show {
        opacity: 1; /* Make visible */
        transform: translateY(0); /* Move to original position */
    }

    .navbar-nav .nav-link:hover {
        color: #f8c146 !important;
    }

    .dropdown-menu {
        min-width: 180px;
        border-radius: 5px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
    }

    .dropdown-menu a {
        font-size: 14px;
        color: #333 !important;
        padding: 8px 15px;
        transition: 0.3s;
    }

    .dropdown-menu a:hover {
        background-color: #f8c146;
        color: white !important;
    }

    /* Enable hover dropdown */
    .nav-item.dropdown:hover .dropdown-menu {
        display: block;
        margin-top: 0;
    }

    /* Center Navbar Links in Mobile View */
    @media (max-width: 991px) {
        .navbar-collapse {
            text-align: center;
        }
        .navbar-nav {
            flex-direction: column;
            width: 100%;
        }
        .navbar-nav .nav-item {
            width: 100%;
        }
    }
</style>

<script>
    // Function to show the navbar links with animation
    window.addEventListener('DOMContentLoaded', (event) => {
        const links = document.querySelectorAll('.navbar-nav .nav-link');
        links.forEach((link, index) => {
            setTimeout(() => {
                link.classList.add('show'); // Add the show class to trigger animation
            }, index * 100); // Stagger the animation for each link
        });
    });
</script>
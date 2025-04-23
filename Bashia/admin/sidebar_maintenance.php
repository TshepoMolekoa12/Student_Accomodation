<div id="sidebar" class="d-flex flex-column flex-shrink-0 p-3 bg-dark text-white vh-100 position-fixed"
     style="width: 250px; transition: all 0.3s ease;">
    <button class="btn btn-sm btn-light d-md-none mb-2" onclick="toggleSidebar()">
        <i class="bi bi-list"></i> Menu
    </button>
    <a href="dashboard.php" class="text-white text-decoration-none d-flex align-items-center mb-3">
        <img src="../uploads/logo.jpg" alt="Logo" width="40" class="me-2">
        <span class="fs-5">Admin Panel</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="employee_dashboard.php" class="nav-link text-white"><i class="bi bi-house-door"></i> Dashboard</a>
        </li>
        <li>
            <a href="manage_employees.php" class="nav-link text-white"><i class="bi bi-people"></i> Employees</a>
        </li>
        <li>
            <a href="manage_properties.php" class="nav-link text-white"><i class="bi bi-building"></i> Properties</a>
        </li>
        <li>
            <a href="manage_tenants.php" class="nav-link text-white"><i class="bi bi-person"></i> Tenants</a>
        </li>
    </ul>
    <hr>
    <a href="../logout.php" class="text-white text-decoration-none"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<script>
    function toggleSidebar() {
        var sidebar = document.getElementById("sidebar");
        if (sidebar.style.marginLeft === "0px") {
            sidebar.style.marginLeft = "-250px";
        } else {
            sidebar.style.marginLeft = "0px";
        }
    }
</script>

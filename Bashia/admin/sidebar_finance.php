<style>
    #sidebar {
        background: #2c3e50;
        color: white;
        height: 100vh;
        width: 250px;
        transition: all 0.3s ease;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.5);
        font-family: 'Arial', sans-serif;
    }
    #sidebar .nav-link {
        color: white;
        padding: 12px;
        transition: background 0.3s ease, padding-left 0.3s ease;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    #sidebar .nav-link:hover {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 5px;
        padding-left: 20px;
    }
    #sidebar img {
        border-radius: 5px;
    }
    #sidebar hr {
        border-top: 1px solid rgba(255, 255, 255, 0.3);
    }
    .toggle-btn {
        background: #ecf0f1;
        border-radius: 5px;
        padding: 6px 12px;
        margin-bottom: 10px;
        border: none;
        cursor: pointer;
    }
    .toggle-btn:hover {
        background: #bdc3c7;
    }
</style>

<div id="sidebar" class="d-flex flex-column flex-shrink-0 p-3 vh-100 position-fixed">
    <button class="btn btn-sm toggle-btn d-md-none" onclick="toggleSidebar()">
        <i class="bi bi-list"></i> Menu
    </button>
    <a href="dashboard.php" class="text-white text-decoration-none d-flex align-items-center mb-3">
        <img src="../uploads/logo.jpg" alt="Logo" width="40" class="me-2">
        <span class="fs-5 fw-bold">Finance Panel</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="finance_dashboard.php" class="nav-link"><i class="bi bi-house-door"></i> Dashboard</a>
        </li>
        <li>
            <a href="pending_payments.php" class="nav-link"><i class="bi bi-credit-card"></i> Pending Payments</a>
        </li>
        <li>
            <a href="invoices_receipts.php" class="nav-link"><i class="bi bi-receipt"></i> Invoices & Receipts</a>
        </li>
        <li>
            <a href="financial_reports.php" class="nav-link"><i class="bi bi-bar-chart"></i> Financial Reports</a>
        </li>
        <li>
            <a href="refunds_disputes.php" class="nav-link"><i class="bi bi-arrow-repeat"></i> Refunds & Disputes</a>
        </li>
        <li>
            <a href="rental_income.php" class="nav-link"><i class="bi bi-cash-stack"></i> Rental Income</a>
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
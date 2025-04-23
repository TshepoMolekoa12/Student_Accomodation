<?php
// refund.php

// Include database connection
include 'db_connection.php'; // Make sure to create this file to handle DB connection
include 'sidebar.php'; // Include the sidebar

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $student_id = $_POST['student_id'];
    $application_id = $_POST['application_id'];
    $reason = $_POST['reason'];

    // Validate input
    if (empty($student_id) || empty($application_id) || empty($reason)) {
        echo "All fields are required.";
        exit;
    }

    // Prepare SQL statement to insert refund request
    $stmt = $conn->prepare(" INSERT INTO refund_requests (student_id, application_id, reason, status) VALUES (?, ?, ?, 'pending')");
    $stmt->bind_param("iis", $student_id, $application_id, $reason);

    if ($stmt->execute()) {
        echo "Refund request submitted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund Request</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your main CSS file -->
    <link rel="stylesheet" href="sidebar.css"> <!-- Link to your sidebar CSS file -->
</head>
<body>
    <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
    
    <!-- Sidebar included here -->
    <?php include 'sidebar.php'; ?>

    <div class="content" id="content">
        <h1>Request a Refund</h1>
        <form action="refund.php" method="POST">
            <label for="student_id">Student ID:</label>
            <input type="text" id="student_id" name="student_id" required><br>

            <label for="application_id">Application ID:</label>
            <input type="text" id="application_id" name="application_id" required><br>

            <label for="reason">Reason for Refund:</label>
            <textarea id="reason" name="reason" required></textarea><br>

            <input type="submit" value="Submit Refund Request">
        </form>
    </div>

    <script>
        function toggleSidebar() {
            var sidebar = document.getElementById("sidebar");
            if (sidebar.style.transform === "translateX(0px)" || sidebar.style.transform === "") {
                sidebar.style.transform = "translateX(-250px)";
            } else {
                sidebar.style.transform = "translateX(0px)";
            }
        }
    </script>
</body>
</html>
<?php
include 'db_connection.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the submitted data
    $guarantor_name = $_POST['guarantor_name'];
    $guarantor_phone = $_POST['guarantor_phone'];
    $guarantor_email = $_POST['guarantor_email'];
    $guarantor_employment_status = $_POST['employment_status'];
    $guarantor_salary_range = $_POST['salary_range'];

    // Handle file upload
    $proof_of_income = $_FILES['proof_of_income'];
    $upload_dir = 'uploads/'; // Ensure this directory exists and is writable
    $upload_file = $upload_dir . basename($proof_of_income['name']);
    
    // Validate inputs
    if (empty($guarantor_name) || empty($guarantor_phone) || empty($guarantor_email) || empty($guarantor_employment_status) || empty($guarantor_salary_range) || empty($proof_of_income['name'])) {
        $_SESSION['error'] = 'All fields are required.';
        header("Location: profile.php");
        exit();
    }

    // Validate file upload
    if ($proof_of_income['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['error'] = 'Error uploading the proof of income file.';
        header("Location: profile.php");
        exit();
    }

    // Move the uploaded file to the designated directory
    if (!move_uploaded_file($proof_of_income['tmp_name'], $upload_file)) {
        $_SESSION['error'] = 'Failed to save the proof of income file.';
        header("Location: profile.php");
        exit();
    }

    // Prepare SQL query
    $sql = "INSERT INTO guarantor_details (user_id, guarantor_name, guarantor_phone, guarantor_email, employment_status, salary_range, proof_of_income) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters
        $stmt->bind_param('issssss', $user_id, $guarantor_name, $guarantor_phone, $guarantor_email, $guarantor_employment_status, $guarantor_salary_range, $upload_file);

        // Execute the statement
        if ($stmt->execute()) {
            $_SESSION['success'] = 'Guarantor details saved successfully.';
        } else {
            $_SESSION['error'] = 'Failed to save guarantor details: ' . $stmt->error;
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = 'Database error: ' . $conn->error;
    }

    // Redirect to the profile page
    header("Location: profile.php");
    exit();
}
?>
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
    $emergency_name = $_POST['contact_name'];
    $emergency_phone = $_POST['contact_phone'];
    $emergency_relationship = $_POST['relationship'];

    // Validate inputs
    if (empty($emergency_name) || empty($emergency_phone) || empty($emergency_relationship)) {
        $_SESSION['error'] = 'All fields are required.';
        header("Location: profile.php");
        exit();
    }

    // Prepare SQL query
    $sql = "INSERT INTO emergency_contact (user_id, contact_name, contact_phone, relationship) 
            VALUES (?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters (note: 'i' for integer, 's' for string)
        $stmt->bind_param('isss', $user_id, $emergency_name, $emergency_phone, $emergency_relationship);

        // Execute the query
        if ($stmt->execute()) {
            $_SESSION['success'] = 'Emergency contact saved successfully.';
        } else {
            $_SESSION['error'] = 'Failed to save emergency contact: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        // Show the error if the prepare statement fails
        $_SESSION['error'] = 'Error in preparing the SQL statement: ' . $conn->error;
    }

    header("Location: profile.php");
    exit();
}
?>
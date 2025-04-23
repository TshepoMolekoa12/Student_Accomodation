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
    $property_type = $_POST['property_type'];
    $check_in_date = $_POST['check_in_date'];
    $check_out_date = $_POST['check_out_date'];
    $special_requirements = $_POST['special_requirements'];

    // Validate inputs
    if (empty($property_type) || empty($check_in_date) || empty($check_out_date)) {
        $_SESSION['error'] = 'Property type, check-in date, and check-out date are required.';
        header("Location: profile.php");
        exit();
    }

    // Prepare SQL query
    $sql = "INSERT INTO accommodation_preferences (user_id, property_type, check_in_date, check_out_date, special_requirements) 
            VALUES (?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters (note: 'i' for integer, 's' for string)
        $stmt->bind_param('issss', $user_id, $property_type, $check_in_date, $check_out_date, $special_requirements);

        // Execute the query
        if ($stmt->execute()) {
            $_SESSION['success'] = 'Accommodation preferences saved successfully.';
        } else {
            $_SESSION['error'] = 'Failed to save accommodation preferences: ' . $stmt->error;
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
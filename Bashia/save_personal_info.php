<?php
include 'db_connection.php'; // Include your database connection file
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the submitted data
    $identity_no = $_POST['identity_no'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $date_of_birth = $_POST['date_of_birth'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip_code = $_POST['zip_code'];
    $country = $_POST['country'];

    // Prepare the SQL update statement
    $sql = "UPDATE personal_info SET 
                identity_no = ?, 
                first_name = ?, 
                last_name = ?, 
                date_of_birth = ?, 
                phone_number = ?, 
                address = ?, 
                city = ?, 
                state = ?, 
                zip_code = ?, 
                country = ? 
            WHERE user_id = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters
        $stmt->bind_param('ssssssssssi', $identity_no, $first_name, $last_name, $date_of_birth, $phone_number, $address, $city, $state, $zip_code, $country, $user_id);

        // Execute the query
        if ($stmt->execute()) {
            $_SESSION['success'] = 'Personal information updated successfully.';
        } else {
            $_SESSION['error'] = 'Failed to update personal information: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = 'Error in preparing the SQL statement: ' . $conn->error;
    }

    // Redirect back to the dashboard or personal info page
    header("Location: user_dashboard.php");
    exit();
}
?>
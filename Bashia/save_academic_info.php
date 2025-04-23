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
    $student_no = $_POST['student_no'];
    $institution_name = $_POST['institution_name'];
    $study_programme = $_POST['study_programme'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Validate inputs
    if (empty($student_no) || empty($institution_name) || empty($study_programme) || empty($start_date) || empty($end_date)) {
        $_SESSION['error'] = 'All fields are required.';
        header("Location: profile.php");
        exit();
    }

    // Prepare SQL query
    $sql = "INSERT INTO academic_info (user_id, student_no, institution_name, study_programme, start_date, end_date) 
            VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters (note: 'i' for integer, 's' for string)
        $stmt->bind_param('isssss', $user_id, $student_no, $institution_name, $study_programme, $start_date, $end_date);

        // Execute the query
        if ($stmt->execute()) {
            $_SESSION['success'] = 'Academic information saved successfully.';
        } else {
            $_SESSION['error'] = 'Failed to save academic information: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        // Show the error if the prepare statement fails
        $_SESSION['error'] = 'Error in preparing the SQL statement: ' . $conn->error;
    }

    // Redirect to the profile page after saving
    header("Location: profile.php");
    exit();
}
?>
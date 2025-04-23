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
    // Handle file uploads
    $upload_dir = 'uploads/documents/'; // Ensure this directory exists and is writable

    // Array to hold file upload errors
    $upload_errors = [];

    // Process each file
    $files = [
        'proof_of_funding' => $_FILES['proof_of_funding'],
        'id_or_passport' => $_FILES['id_or_passport'],
        'proof_of_registration' => $_FILES['proof_of_registration'],
        'proof_of_address' => $_FILES['proof_of_address'],
    ];

    // Variables to hold the file paths
    $proof_of_funding_path = '';
    $id_or_passport_path = '';
    $proof_of_registration_path = '';
    $proof_of_address_path = '';

    foreach ($files as $key => $file) {
        // Check for upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $upload_errors[$key] = 'Error uploading ' . $key . '.';
            continue;
        }

        // Move the uploaded file to the designated directory
        $upload_file = $upload_dir . basename($file['name']);
        if (!move_uploaded_file($file['tmp_name'], $upload_file)) {
            $upload_errors[$key] = 'Failed to save ' . $key . '.';
        } else {
            // Store the file path in the corresponding variable
            switch ($key) {
                case 'proof_of_funding':
                    $proof_of_funding_path = $upload_file;
                    break;
                case 'id_or_passport':
                    $id_or_passport_path = $upload_file;
                    break;
                case 'proof_of_registration':
                    $proof_of_registration_path = $upload_file;
                    break;
                case 'proof_of_address':
                    $proof_of_address_path = $upload_file;
                    break;
            }
        }
    }

    // Check if there were any errors
    if (!empty($upload_errors)) {
        $_SESSION['error'] = implode('<br>', $upload_errors);
        header("Location: profile.php");
        exit();
    }

    // Prepare SQL query to save file paths to the database
    $sql = "INSERT INTO documents_upload (user_id, proof_of_funding, id_or_passport, proof_of_registration, proof_of_address) VALUES (?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters
        $stmt->bind_param('issss', $user_id, $proof_of_funding_path, $id_or_passport_path, $proof_of_registration_path, $proof_of_address_path);

        // Execute the query
        if ($stmt->execute()) {
            $_SESSION['success'] = 'Documents uploaded and saved to the database successfully.';
        } else {
            $_SESSION['error'] = 'Failed to save documents to the database: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = 'Database error: ' . $conn->error;
    }

    header("Location: profile.php");
    exit();
}
?>
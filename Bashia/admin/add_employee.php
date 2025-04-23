<?php
include '../db_connection.php'; // Ensure your database connection is included
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $position = $_POST['position'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash password

    // Prepare SQL statement
    $sql = "INSERT INTO employees (email, name, position, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("ssss", $email, $name, $position, $password);
        
        // Execute statement
        if ($stmt->execute()) {
            echo "Employee added successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    } else {
        echo "Error preparing SQL: " . $conn->error;
    }

    // Close connection
    $conn->close();
} else {
    echo "Invalid request!";
}
?>

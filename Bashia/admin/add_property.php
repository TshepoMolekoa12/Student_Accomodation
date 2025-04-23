<?php
include '../db_connection.php';
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $total_rooms = intval($_POST['total_rooms']);
    $available_rooms = intval($_POST['available_rooms']);
    $rental_price = floatval($_POST['rental_price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    
    // Handle Image Upload
    $image = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../uploads/";
        $image = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    }

    // Insert into Database
    $sql = "INSERT INTO properties (name, location, total_rooms, available_rooms, rental_price, description, image) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssiiiss", $name, $location, $total_rooms, $available_rooms, $rental_price, $description, $image);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Property added successfully!";
    } else {
        $_SESSION['error'] = "Error adding property: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    header("Location: manage_properties.php");
    exit();
}
?>

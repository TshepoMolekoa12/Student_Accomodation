<?php
include '../db_connection.php';
session_start();

if (!isset($_SESSION['employee_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $total_rooms = intval($_POST['total_rooms']);
    $available_rooms = intval($_POST['available_rooms']);
    $rental_price = floatval($_POST['rental_price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Check if a new image was uploaded
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../uploads/";
        $image = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

        // Update with image
        $sql = "UPDATE properties SET name=?, location=?, total_rooms=?, available_rooms=?, rental_price=?, description=?, image=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssiiissi", $name, $location, $total_rooms, $available_rooms, $rental_price, $description, $image, $id);
    } else {
        // Update without changing image
        $sql = "UPDATE properties SET name=?, location=?, total_rooms=?, available_rooms=?, rental_price=?, description=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssiiisi", $name, $location, $total_rooms, $available_rooms, $rental_price, $description, $id);
    }

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Property updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating property: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    header("Location: manage_properties.php");
    exit();
}
?>

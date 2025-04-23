<?php
include '../db_connection.php';

session_start();
if (!isset($_SESSION['employee_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $position = $_POST['position'];

    $update_query = "UPDATE employees SET name=?, email=?, position=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, "sssi", $name, $email, $position, $id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Employee updated successfully'); window.location='manage_employees.php';</script>";
    } else {
        echo "Error updating employee: " . mysqli_error($conn);
    }
}
?>

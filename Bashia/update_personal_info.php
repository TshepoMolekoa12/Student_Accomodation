<?php
include 'db_connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $identity_no = $_POST['identity_no'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $date_of_birth = $_POST['date_of_birth'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip_code = $_POST['zip_code'];
    $country = $_POST['country'];

    $stmt = $conn->prepare("UPDATE personal_info SET identity_no = ?, first_name = ?, last_name = ?, date_of_birth = ?, phone_number = ?, email = ?, address = ?, city = ?, state = ?, zip_code = ?, country = ? WHERE user_id = ?");
    $stmt->bind_param("sssssssssssi", $identity_no, $first_name, $last_name, $date_of_birth, $phone_number, $email, $address, $city, $state, $zip_code, $country, $user_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
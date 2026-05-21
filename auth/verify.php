<?php
include '../config/db.php';
include '../includes/functions.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $stmt = $conn->prepare("SELECT id FROM users WHERE verification_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $update = $conn->prepare("UPDATE users SET verified = 1, verification_token = NULL WHERE id = ?");
        $update->bind_param("i", $row['id']);
        if ($update->execute()) {
            echo "Email verified successfully!";
        } else {
            echo "Update failed";
        }
    } else {
        echo "Invalid token";
    }
} else {
    echo "No token provided";
}
?>
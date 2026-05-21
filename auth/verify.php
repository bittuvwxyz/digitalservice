<?php
include '../config/db.php';
include '../includes/functions.php';

$token = $_GET['token'];

$stmt = $conn->prepare("SELECT * FROM email_verifications WHERE token=?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    if (!isTokenExpired($row['expires_at'])) {

        $conn->query("UPDATE users SET is_verified=1 WHERE id=" . $row['user_id']);
        $conn->query("DELETE FROM email_verification WHERE user_id=" . $row['user_id']);

        echo "Email verified!";
    } else {
        echo "Token expired";
    }
} else {
    echo "Invalid token";
}
?>
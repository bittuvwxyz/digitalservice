<?php
require '../config/db.php';
require '../includes/functions.php';
require '../includes/mail.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $email = trim($_POST['email'] ?? '');
    
    if (!$email) die("Email required");
    
    $stmt = $conn->prepare("SELECT id, username FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        die("No user found");
    }

    $user = $result->fetch_assoc();

    // token
    $token = bin2hex(random_bytes(32));
    $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

    // save
    $stmt = $conn->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user['id'], $token, $expiry);
    $stmt->execute();

    // 🔗 link
    $link = "http://localhost/auth/reset_password.php?token=" . urlencode($token);

    $message = "
        <h2>Password Reset</h2>
        <p>Click below:</p>
        <a href='$link'>$link</a>
    ";

    sendMail($email, $user['username'], $message);

    echo "Reset link sent to email";
}
?>
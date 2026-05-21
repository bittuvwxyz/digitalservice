<?php
session_start();

require '../db.php';
require '../includes/functions.php';
require '../includes/mail.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (!$username || !$email || !$password) {
        die("All fields are required");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    if (strlen($password) < 6) {
        die("Password must be at least 6 characters");
    }
    
    $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
    if (!$stmt) die("Prepare failed: " . $conn->error);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        die("Email already registered");
    }
    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    if (!$stmt) die("Insert prepare failed: " . $conn->error);
    $stmt->bind_param("sss", $username, $email, $hashedPassword);
    if (!$stmt->execute()) {
        die("Insert failed: " . $stmt->error);
    }
    $user_id = $stmt->insert_id;
    
    $token = bin2hex(random_bytes(32));
    $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

    if (!$token) {
        die("Token generation failed");
    }
    
    $stmt = $conn->prepare("INSERT INTO email_verification (user_id, token, expires_at) VALUES (?, ?, ?)");
    if (!$stmt) die("Token prepare failed: " . $conn->error);

    $stmt->bind_param("iss", $user_id, $token, $expiry);

    if (!$stmt->execute()) {
        die("Token insert failed: " . $stmt->error);
    }
$base_url = "http://localhost/";
$link = $base_url . "auth/verify.php?token=" . urlencode($token);
$message = "
<h2>Email Verification</h2>
<p>Click below to verify your email:</p>
<p><a href=\"{$link}\">Verify Email</a></p>
<p>Or copy this link:</p>
<p>{$link}</p>";
$mailStatus = sendMail($email, $username, $message);
if ($mailStatus === true) {
echo "Registered! Check your email.";
} else {
echo "Registered, but email failed: " . $mailStatus;
}
}
?>
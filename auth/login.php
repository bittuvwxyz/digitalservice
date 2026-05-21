<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

require '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) {
        die("All fields are required");
    }

    // 🔹 Fetch user
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("User not found");
    }

    $user = $result->fetch_assoc();

    // 🔐 Check verification
    if ((int)$user['is_verified'] !== 1) {
        die("Please verify your email first");
    }

    // 🔐 Check password
    if (!password_verify($password, $user['password'])) {
        die("Wrong password");
    }

    // ✅ Set session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];

    // 🚀 REDIRECT (IMPORTANT)
    header("Location: ../dashboard.php");
    exit;
}
?>
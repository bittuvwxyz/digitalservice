<?php
session_start();

require '../config/db.php';

$token = $_GET['token'] ?? '';

if (!$token) die("Invalid token");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $password = $_POST['password'] ?? '';

    if (strlen($password) < 6) {
        die("Password must be at least 6 characters");
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT * FROM password_resets WHERE token=?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Invalid token");
    }

    $row = $result->fetch_assoc();

    if (strtotime($row['expires_at']) < time()) {
        die("Token expired");
    }

    $conn->query("UPDATE users SET password='$hashed' WHERE id={$row['user_id']}");

    $conn->query("DELETE FROM password_resets WHERE user_id={$row['user_id']}");

    header("Location: ../login.html");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<div class="box">
    <h3>Reset Password</h3>
    <form method="POST">
        <input type="password" name="password" placeholder="New Password" required>
        <button type="submit">Update Password</button>
    </form>
</div>

</body>
</html>
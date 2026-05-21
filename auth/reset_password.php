<?php
session_start();

require '../config/db.php';

$token = $_GET['token'] ?? '';

if (!$token) die("Invalid token");

// 🔹 Handle POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $password = $_POST['password'] ?? '';

    if (strlen($password) < 6) {
        die("Password must be at least 6 characters");
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // 🔹 Check token
    $stmt = $conn->prepare("SELECT * FROM password_resets WHERE token=?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Invalid token");
    }

    $row = $result->fetch_assoc();

    // 🔹 Check expiry
    if (strtotime($row['expires_at']) < time()) {
        die("Token expired");
    }

    // 🔹 Update password
    $conn->query("UPDATE users SET password='$hashed' WHERE id={$row['user_id']}");

    // 🔹 Delete token
    $conn->query("DELETE FROM password_resets WHERE user_id={$row['user_id']}");

    // ✅ Redirect to login
    header("Location: ../login.html");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            background: #f5f7fa;
            font-family: Arial;
        }

        .box {
            width: 350px;
            margin: 100px auto;
            padding: 25px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
        }

        button {
            margin-top: 15px;
            padding: 10px;
            width: 100%;
            background: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }
    </style>
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
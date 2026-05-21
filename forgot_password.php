<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Forgot Password</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<h3>Forgot Password</h3>
<p>Enter your email to receive a reset link</p>
<form method="POST" action="auth/forgot_password.php">
<input type="email" name="email" required>
<button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
</form>

</body>
</html>
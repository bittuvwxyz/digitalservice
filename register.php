<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<h3>Register</h3>
<form method="POST" action="/auth/register.php" onsubmit="return validateForm()">
<label>Username</label>
<input type="text" name="username" id="username" class="form-control" required>
<label class="form-label">Email</label>
<input type="email" name="email" id="email" class="form-control" required>
<label class="form-label">Password</label>
<input type="password" name="password" id="password" class="form-control" required>
<!-- Error Message -->
<div id="error" class="text-danger mb-2"></div>
<!-- Submit -->
<button type="submit">Register</button>
</form>
<p><a href="login.php">Login</a></p>

</body>
</html>
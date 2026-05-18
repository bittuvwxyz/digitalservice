# digitalservice

Simple PHP MySQL project with `.env` database configuration support.

---

# Features

- `.env` configuration support
- MySQL database connection
- Secure config handling
- `.gitignore` included

---

# Project Structure

```txt
digitalservice/
│
├── .env
├── env.php
├── db.php
├── index.php
├── README.md
├── .gitignore
│
├── includes/
│   └── db.php
│
├── uploads/
├── storage/
├── logs/
│
├── vendor/
└── node_modules/
```

---

# Setup

## Clone Repository

```bash
git clone git@github.com:bittuvwxyz/digitalservice.git
cd digitalservice
```

---

# Create `.env`

```env
DB_HOST=localhost
DB_NAME=testdb
DB_USER=root
DB_PASS=
```

---

# env.php

```php
<?php

$env = parse_ini_file(__DIR__ . '/.env');

define('DB_HOST', $env['DB_HOST']);
define('DB_NAME', $env['DB_NAME']);
define('DB_USER', $env['DB_USER']);
define('DB_PASS', $env['DB_PASS']);
```

---

# db.php

```php
<?php

require_once 'env.php';

$conn = mysqli_connect(
    DB_HOST,
    DB_USER,
    DB_PASS,
    DB_NAME
);

if (!$conn) {
    die("Database connection failed");
}
```

---

# Use Anywhere

```php
<?php

require_once 'db.php';
$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
```

---

# `.gitignore`

```gitignore
/vendor/
/node_modules/
.env
env.php
db.php
.DS_Store
Thumbs.db
```

---

# Git Commands

```bash
echo "# digitalservice" >> README.md

git init

git add .

git commit -m "first commit"

git branch -M main

git remote add origin git@github.com:bittuvwxyz/digitalservice.git

git push -u origin main
```

---

# Important Notes

- Never upload `.env` to GitHub
- Keep database credentials private
- Use `.gitignore`
- Use App Password for Gmail SMTP

---

# License

MIT

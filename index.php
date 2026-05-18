<?php

require_once 'db.php';

require_once 'config/config.php';
require_once 'includes/functions.php';

$page = $_GET['page'] ?? 'home';

$allowed_pages = [
    'home',
    'about',
    'contact'
];

if (!in_array($page, $allowed_pages)) {
    $page = '404';
}

require_once 'includes/header.php';
require_once 'includes/homelanding.php';
// require_once 'includes/navbar.php';
require_once 'pages/' . $page . '.php';
require_once 'includes/footer.php';
<?php

require_once 'db.php';

require_once 'config/config.php';
require_once 'includes/functions.php';

$page = $_GET['page'] ?? 'index';

$allowed_pages = [
    'index',
    'post',
    'blog'
];

if (!in_array($page, $allowed_pages)) {
    $page = '404';
}

require_once 'includes/header.php';
require_once 'includes/homelanding.php';
require_once 'includes/footer.php';
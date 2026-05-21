<?php

require '../config/db.php';

if (!defined('APP_ALLOWED')) {
    header("Location: /index.php");
    exit;
}
?>
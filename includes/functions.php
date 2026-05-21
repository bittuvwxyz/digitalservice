<?php

function escape($data)
{
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

function generateToken() {
    return bin2hex(random_bytes(32));
}

function isTokenExpired($expiry) {
    return strtotime($expiry) < time();
}

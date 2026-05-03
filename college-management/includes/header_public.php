<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? e($page_title).' - ' : '' ?>Moonje College Management</title>
    <link rel="stylesheet" href="<?= isset($base_path) ? $base_path : '' ?>assets/css/style.css">
</head>
<body>
<nav class="navbar">
    <a class="brand" href="<?= isset($base_path) ? $base_path : '' ?>index.php">
        <span class="logo">M</span> Moonje College
    </a>
    <ul>
        <li><a href="<?= isset($base_path) ? $base_path : '' ?>index.php">Home</a></li>
        <li><a href="<?= isset($base_path) ? $base_path : '' ?>index.php#about">About</a></li>
        <li><a href="<?= isset($base_path) ? $base_path : '' ?>index.php#features">Features</a></li>
        <li><a href="<?= isset($base_path) ? $base_path : '' ?>student/login.php">Student Login</a></li>
        <li><a href="<?= isset($base_path) ? $base_path : '' ?>teacher/login.php">Teacher Login</a></li>
    </ul>
</nav>

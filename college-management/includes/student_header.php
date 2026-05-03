<?php
require_once __DIR__ . '/../config/db.php';
requireStudent();
$current = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? e($page_title) : 'Student Dashboard' ?> - Moonje College</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<nav class="navbar">
    <a class="brand" href="dashboard.php">
        <span class="logo">M</span> Dr. Moonje Institute of Management and Computer Studies
    </a>
    <div class="user-menu">
        <span class="badge">Student</span>
        <span><?= e($_SESSION['student_name']) ?></span>
        <a href="logout.php" class="btn btn-sm btn-secondary">Logout</a>
    </div>
</nav>
<div class="layout">
    <aside class="sidebar">
        <h3>Student Menu</h3>
        <ul>
            <li><a href="dashboard.php"   class="<?= $current=='dashboard.php'?'active':'' ?>"><span class="icon">⌂</span> Dashboard</a></li>
            <li><a href="syllabus.php"    class="<?= $current=='syllabus.php'?'active':'' ?>"><span class="icon">📚</span> Syllabus</a></li>
            <li><a href="timetable.php"   class="<?= $current=='timetable.php'?'active':'' ?>"><span class="icon">🗓</span> Time Table</a></li>
            <li><a href="examination.php" class="<?= $current=='examination.php'?'active':'' ?>"><span class="icon">📝</span> Examination</a></li>
            <li><a href="fees.php"        class="<?= $current=='fees.php'?'active':'' ?>"><span class="icon">💰</span> Fees</a></li>
            <li><a href="notices.php"     class="<?= $current=='notices.php'?'active':'' ?>"><span class="icon">📢</span> Notices</a></li>
            <li><a href="events.php"      class="<?= $current=='events.php'?'active':'' ?>"><span class="icon">🎉</span> Events</a></li>
            <li><a href="direction.php"   class="<?= $current=='direction.php'?'active':'' ?>"><span class="icon">📍</span> Get Direction</a></li>
            <li><a href="profile.php"     class="<?= $current=='profile.php'?'active':'' ?>"><span class="icon">👤</span> My Profile</a></li>
        </ul>
    </aside>
    <main class="main-content">

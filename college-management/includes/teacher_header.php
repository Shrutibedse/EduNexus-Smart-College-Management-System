<?php
require_once __DIR__ . '/../config/db.php';
requireTeacher();
$current = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? e($page_title) : 'Teacher Dashboard' ?> - Moonje College</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<nav class="navbar">
    <a class="brand" href="dashboard.php">
        <span class="logo">M</span>  Dr. Moonje Institute of Management and Computer Studies
    </a>
    <div class="user-menu">
        <span class="badge" style="background:#16a34a; color:#fff;">Teacher</span>
        <span><?= e($_SESSION['teacher_name']) ?></span>
        <a href="logout.php" class="btn btn-sm btn-secondary">Logout</a>
    </div>
</nav>
<div class="layout">
    <aside class="sidebar">
        <h3>Teacher Menu</h3>
        <ul>
            <li><a href="dashboard.php"     class="<?= $current=='dashboard.php'?'active':'' ?>"><span class="icon">⌂</span> Dashboard</a></li>
            <li><a href="students.php"      class="<?= $current=='students.php'?'active':'' ?>"><span class="icon">👥</span> Students</a></li>
            <li><a href="add_student.php"   class="<?= $current=='add_student.php'?'active':'' ?>"><span class="icon">➕</span> Add Student</a></li>
            <li><a href="notices.php"       class="<?= $current=='notices.php'?'active':'' ?>"><span class="icon">📢</span> Notices</a></li>
            <li><a href="add_notice.php"    class="<?= $current=='add_notice.php'?'active':'' ?>"><span class="icon">✏</span> Add Notice</a></li>
            <li><a href="timetable.php"     class="<?= $current=='timetable.php'?'active':'' ?>"><span class="icon">🗓</span> Time Table</a></li>
            <li><a href="add_timetable.php" class="<?= $current=='add_timetable.php'?'active':'' ?>"><span class="icon">➕</span> Add Period</a></li>
            <li><a href="events.php"        class="<?= $current=='events.php'?'active':'' ?>"><span class="icon">🎉</span> Events</a></li>
            <li><a href="add_event.php"     class="<?= $current=='add_event.php'?'active':'' ?>"><span class="icon">➕</span> Add Event</a></li>
            <li><a href="exams.php"         class="<?= $current=='exams.php'?'active':'' ?>"><span class="icon">📝</span> Examinations</a></li>
            <li><a href="add_exam.php"      class="<?= $current=='add_exam.php'?'active':'' ?>"><span class="icon">➕</span> Add Exam</a></li>
            <li><a href="fees.php"          class="<?= $current=='fees.php'?'active':'' ?>"><span class="icon">💰</span> Fees Records</a></li>
        </ul>
    </aside>
    <main class="main-content">

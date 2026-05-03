<?php
// =====================================================
// Database Connection - XAMPP defaults
// =====================================================
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';            // XAMPP default = empty
$db_name = 'college_db';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

// Start session for every request that uses this file
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Helper - escape output
function e($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

// Helper - redirect
function redirect($url) {
    header("Location: $url");
    exit();
}

// Auth guards
function requireStudent() {
    if (empty($_SESSION['student_id'])) {
        redirect('../student/login.php');
    }
}

function requireTeacher() {
    if (empty($_SESSION['teacher_id'])) {
        redirect('../teacher/login.php');
    }
}

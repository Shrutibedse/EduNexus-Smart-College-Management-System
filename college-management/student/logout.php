<?php
require_once '../config/db.php';
unset($_SESSION['student_id'], $_SESSION['student_name'], $_SESSION['student_roll'], $_SESSION['student_course'], $_SESSION['student_year']);
session_destroy();
redirect('login.php');

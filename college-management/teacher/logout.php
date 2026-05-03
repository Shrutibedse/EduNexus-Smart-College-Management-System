<?php
require_once '../config/db.php';
unset($_SESSION['teacher_id'], $_SESSION['teacher_name'], $_SESSION['teacher_dept'], $_SESSION['teacher_emp']);
session_destroy();
redirect('login.php');

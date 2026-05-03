<?php
require_once '../config/db.php';
$error='';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';
    if (!$email || !$pass) {
        $error = 'Please enter email and password.';
    } else {
        $stmt = $conn->prepare("SELECT * FROM teachers WHERE email=? LIMIT 1");
        $stmt->bind_param('s', $email); $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows===1) {
            $u = $res->fetch_assoc();
            if (password_verify($pass, $u['password'])) {
                $_SESSION['teacher_id']   = $u['id'];
                $_SESSION['teacher_name'] = $u['name'];
                $_SESSION['teacher_dept'] = $u['department'];
                $_SESSION['teacher_emp']  = $u['employee_id'];
                redirect('dashboard.php');
            } else $error = 'Invalid password.';
        } else $error = 'Account not found.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Login - Moonje College</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="auth-wrap">
    <div class="auth-box">
        <h2>Teacher Portal</h2>
        <p class="sub">Manage students, notices, exams, timetable and more.</p>

        <div class="role-tabs">
            <a href="../student/login.php">Student</a>
            <a href="login.php" class="active">Teacher</a>
        </div>

        <?php if($error): ?>
            <div class="alert alert-danger"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" required placeholder="admin@college.edu" value="<?= e($_POST['email'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn full-btn">Login</button>
        </form>

        <p class="footer-link">
            <a href="../index.php">← Back to home</a>
        </p>

        <div class="alert alert-info" style="margin-top:18px; font-size:13px;">
            <strong>Demo:</strong> admin@college.edu / admin123
        </div>
    </div>
</div>
</body>
</html>

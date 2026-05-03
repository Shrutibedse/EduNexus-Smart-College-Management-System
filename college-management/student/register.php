<?php
require_once '../config/db.php';
$error = ''; $success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roll    = trim($_POST['roll_no'] ?? '');
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $phone   = trim($_POST['phone'] ?? '');
    $course  = $_POST['course'] ?? '';
    $year    = $_POST['year'] ?? '';
    $address = trim($_POST['address'] ?? '');
    $dob     = $_POST['dob'] ?? null;
    $gender  = $_POST['gender'] ?? 'Male';
    $pass    = $_POST['password'] ?? '';
    $cpass   = $_POST['confirm_password'] ?? '';

    if (!$roll || !$name || !$email || !$pass || !$course || !$year) {
        $error = 'Please fill all required fields.';
    } elseif (strlen($pass) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif ($pass !== $cpass) {
        $error = 'Passwords do not match.';
    } else {
        $check = $conn->prepare("SELECT id FROM students WHERE email=? OR roll_no=?");
        $check->bind_param('ss', $email, $roll);
        $check->execute();
        if ($check->get_result()->num_rows) {
            $error = 'Email or Roll number already registered.';
        } else {
            $hash = password_hash($pass, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("INSERT INTO students (roll_no,name,email,phone,password,course,year,address,dob,gender) VALUES (?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param('ssssssssss', $roll,$name,$email,$phone,$hash,$course,$year,$address,$dob,$gender);
            if ($stmt->execute()) {
                $success = 'Account created. You can now login.';
            } else {
                $error = 'Could not create account: ' . $conn->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Register - Moonje College</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="auth-wrap">
    <div class="auth-box" style="max-width:640px;">
        <h2>Create Student Account</h2>
        <p class="sub">Register to access your college portal.</p>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= e($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?= e($success) ?> <a href="login.php">Login →</a></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-grid">
                <div class="form-group">
                    <label>Roll Number *</label>
                    <input type="text" name="roll_no" required value="<?= e($_POST['roll_no'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="name" required value="<?= e($_POST['name'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" required value="<?= e($_POST['email'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" value="<?= e($_POST['phone'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Course *</label>
                    <select name="course" required>
                        <option value="">-- Select --</option>
                        <option>BCA</option>
                        <option>BBA</option>
                        <option>B.Com</option>
                        <option>BA</option>
                        <option>BSc</option>
                        <option>MCA</option>
                        <option>MBA</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Year *</label>
                    <select name="year" required>
                        <option value="">-- Select --</option>
                        <option>1st Year</option>
                        <option>2nd Year</option>
                        <option>3rd Year</option>
                        <option>Final Year</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" name="dob" value="<?= e($_POST['dob'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Gender</label>
                    <select name="gender">
                        <option>Male</option><option>Female</option><option>Other</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Address</label>
                <textarea name="address" rows="2"><?= e($_POST['address'] ?? '') ?></textarea>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label>Password *</label>
                    <input type="password" name="password" required minlength="6">
                </div>
                <div class="form-group">
                    <label>Confirm Password *</label>
                    <input type="password" name="confirm_password" required minlength="6">
                </div>
            </div>
            <button type="submit" class="btn full-btn">Register</button>
        </form>

        <p class="footer-link">
            Already registered? <a href="login.php">Login</a> &nbsp;·&nbsp;
            <a href="../index.php">← Home</a>
        </p>
    </div>
</div>
</body>
</html>

<?php
$page_title = 'My Profile';
require_once '../includes/student_header.php';

$sid = $_SESSION['student_id'];
$msg=''; $err='';

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $phone   = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $stmt = $conn->prepare("UPDATE students SET phone=?, address=? WHERE id=?");
    $stmt->bind_param('ssi', $phone, $address, $sid);
    if ($stmt->execute()) $msg='Profile updated.';
    else $err='Update failed.';
}

$stmt = $conn->prepare("SELECT * FROM students WHERE id=?");
$stmt->bind_param('i', $sid); $stmt->execute();
$me = $stmt->get_result()->fetch_assoc();
?>

<div class="page-header">
    <h1>My Profile</h1>
</div>

<?php if($msg): ?><div class="alert alert-success"><?= e($msg) ?></div><?php endif; ?>
<?php if($err): ?><div class="alert alert-danger"><?= e($err) ?></div><?php endif; ?>

<div class="panel">
    <h3 class="panel-title">Account Details</h3>
    <form method="POST">
        <div class="form-grid">
            <div class="form-group"><label>Roll Number</label><input value="<?= e($me['roll_no']) ?>" disabled></div>
            <div class="form-group"><label>Name</label><input value="<?= e($me['name']) ?>" disabled></div>
            <div class="form-group"><label>Email</label><input value="<?= e($me['email']) ?>" disabled></div>
            <div class="form-group"><label>Course</label><input value="<?= e($me['course']) ?>" disabled></div>
            <div class="form-group"><label>Year</label><input value="<?= e($me['year']) ?>" disabled></div>
            <div class="form-group"><label>Date of Birth</label><input value="<?= e($me['dob']) ?>" disabled></div>
            <div class="form-group"><label>Phone</label><input type="text" name="phone" value="<?= e($me['phone']) ?>"></div>
            <div class="form-group"><label>Gender</label><input value="<?= e($me['gender']) ?>" disabled></div>
        </div>
        <div class="form-group">
            <label>Address</label>
            <textarea name="address" rows="3"><?= e($me['address']) ?></textarea>
        </div>
        <button type="submit" class="btn">Update Profile</button>
    </form>
</div>

<?php require_once '../includes/student_footer.php'; ?>

<?php
$page_title = 'Add Student';
require_once '../includes/teacher_header.php';

$msg=''; $err='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $roll    = trim($_POST['roll_no'] ?? '');
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $phone   = trim($_POST['phone'] ?? '');
    $course  = $_POST['course'] ?? '';
    $year    = $_POST['year'] ?? '';
    $address = trim($_POST['address'] ?? '');
    $dob     = $_POST['dob'] ?? null;
    $gender  = $_POST['gender'] ?? 'Male';
    $pass    = $_POST['password'] ?? 'student123';

    if (!$roll || !$name || !$email || !$course || !$year) {
        $err='Roll, name, email, course and year are required.';
    } else {
        $check = $conn->prepare("SELECT id FROM students WHERE email=? OR roll_no=?");
        $check->bind_param('ss', $email, $roll); $check->execute();
        if ($check->get_result()->num_rows) {
            $err='Roll number or email already exists.';
        } else {
            $hash = password_hash($pass, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("INSERT INTO students (roll_no,name,email,phone,password,course,year,address,dob,gender) VALUES (?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param('ssssssssss', $roll,$name,$email,$phone,$hash,$course,$year,$address,$dob,$gender);
            if ($stmt->execute()) {
                $msg='Student added successfully. Default password is "'.e($pass).'".';
                $_POST=[];
            } else $err='Could not add: '.$conn->error;
        }
    }
}
?>

<div class="page-header">
    <h1>Add Student</h1>
</div>

<?php if($msg): ?><div class="alert alert-success"><?= $msg ?></div><?php endif; ?>
<?php if($err): ?><div class="alert alert-danger"><?= e($err) ?></div><?php endif; ?>

<div class="panel">
    <form method="POST">
        <div class="form-grid">
            <div class="form-group"><label>Roll Number *</label><input type="text" name="roll_no" required value="<?= e($_POST['roll_no'] ?? '') ?>"></div>
            <div class="form-group"><label>Full Name *</label><input type="text" name="name" required value="<?= e($_POST['name'] ?? '') ?>"></div>
            <div class="form-group"><label>Email *</label><input type="email" name="email" required value="<?= e($_POST['email'] ?? '') ?>"></div>
            <div class="form-group"><label>Phone</label><input type="text" name="phone" value="<?= e($_POST['phone'] ?? '') ?>"></div>
            <div class="form-group">
                <label>Course *</label>
                <select name="course" required>
                    <option value="">--</option>
                    <?php foreach(['BCA','BBA','B.Com','BA','BSc','MCA','MBA'] as $c): ?>
                        <option <?= ($_POST['course'] ?? '')===$c?'selected':'' ?>><?= $c ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Year *</label>
                <select name="year" required>
                    <option value="">--</option>
                    <?php foreach(['1st Year','2nd Year','3rd Year','Final Year'] as $y): ?>
                        <option <?= ($_POST['year'] ?? '')===$y?'selected':'' ?>><?= $y ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group"><label>Date of Birth</label><input type="date" name="dob"></div>
            <div class="form-group">
                <label>Gender</label>
                <select name="gender"><option>Male</option><option>Female</option><option>Other</option></select>
            </div>
            <div class="form-group"><label>Default Password</label><input type="text" name="password" value="student123"></div>
        </div>
        <div class="form-group"><label>Address</label><textarea name="address" rows="2"><?= e($_POST['address'] ?? '') ?></textarea></div>
        <button class="btn">Save Student</button>
        <a href="students.php" class="btn btn-light">Cancel</a>
    </form>
</div>

<?php require_once '../includes/teacher_footer.php'; ?>

<?php
$page_title = 'Add Exam';
require_once '../includes/teacher_header.php';

$msg=''; $err='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $name=trim($_POST['exam_name']??''); $course=$_POST['course']??''; $year=$_POST['year']??'';
    $subject=trim($_POST['subject']??''); $date=$_POST['exam_date']??''; $time=$_POST['exam_time']??'';
    $duration=trim($_POST['duration']??''); $venue=trim($_POST['venue']??'');
    if (!$name || !$course || !$year || !$subject || !$date || !$time) $err='Please fill all required fields.';
    else {
        $stmt = $conn->prepare("INSERT INTO examinations (exam_name,course,year,subject,exam_date,exam_time,duration,venue,posted_by) VALUES (?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param('ssssssssi', $name,$course,$year,$subject,$date,$time,$duration,$venue,$_SESSION['teacher_id']);
        if ($stmt->execute()) { $msg='Exam scheduled.'; $_POST=[]; }
        else $err='Failed: '.$conn->error;
    }
}
?>

<div class="page-header"><h1>Add Examination</h1></div>

<?php if($msg): ?><div class="alert alert-success"><?= e($msg) ?> <a href="exams.php">View →</a></div><?php endif; ?>
<?php if($err): ?><div class="alert alert-danger"><?= e($err) ?></div><?php endif; ?>

<div class="panel">
    <form method="POST">
        <div class="form-grid">
            <div class="form-group"><label>Exam Name *</label><input type="text" name="exam_name" required placeholder="e.g. Mid-Term, Unit Test, Final"></div>
            <div class="form-group">
                <label>Course *</label>
                <select name="course" required>
                    <option value="">--</option>
                    <?php foreach(['BCA','BBA','B.Com','BA','BSc','MCA','MBA'] as $c): ?><option><?= $c ?></option><?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Year *</label>
                <select name="year" required>
                    <option value="">--</option>
                    <?php foreach(['1st Year','2nd Year','3rd Year','Final Year'] as $y): ?><option><?= $y ?></option><?php endforeach; ?>
                </select>
            </div>
            <div class="form-group"><label>Subject *</label><input type="text" name="subject" required></div>
            <div class="form-group"><label>Exam Date *</label><input type="date" name="exam_date" required></div>
            <div class="form-group"><label>Exam Time *</label><input type="time" name="exam_time" required></div>
            <div class="form-group"><label>Duration</label><input type="text" name="duration" placeholder="e.g. 3 Hours"></div>
            <div class="form-group"><label>Venue</label><input type="text" name="venue" placeholder="e.g. Hall A-101"></div>
        </div>
        <button class="btn">Save Exam</button>
        <a href="exams.php" class="btn btn-light">Cancel</a>
    </form>
</div>

<?php require_once '../includes/teacher_footer.php'; ?>

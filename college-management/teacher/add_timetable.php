<?php
$page_title = 'Add Period';
require_once '../includes/teacher_header.php';

$teachers = $conn->query("SELECT id,name FROM teachers ORDER BY name");

$msg=''; $err='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $course=$_POST['course']??''; $year=$_POST['year']??'';
    $day=$_POST['day_of_week']??''; $period=(int)($_POST['period_no']??0);
    $start=$_POST['start_time']??''; $end=$_POST['end_time']??'';
    $subject=trim($_POST['subject']??''); $teacher_id=(int)($_POST['teacher_id']??0);
    $room=trim($_POST['room_no']??'');
    if (!$course || !$year || !$day || !$period || !$start || !$end || !$subject) {
        $err='Please fill all required fields.';
    } else {
        $stmt = $conn->prepare("INSERT INTO timetable (course,year,day_of_week,period_no,start_time,end_time,subject,teacher_id,room_no) VALUES (?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param('sssisssis', $course,$year,$day,$period,$start,$end,$subject,$teacher_id,$room);
        if ($stmt->execute()) { $msg='Period added.'; $_POST=[]; }
        else $err='Failed: '.$conn->error;
    }
}
?>

<div class="page-header"><h1>Add Time Table Period</h1></div>

<?php if($msg): ?><div class="alert alert-success"><?= e($msg) ?> <a href="timetable.php">View →</a></div><?php endif; ?>
<?php if($err): ?><div class="alert alert-danger"><?= e($err) ?></div><?php endif; ?>

<div class="panel">
    <form method="POST">
        <div class="form-grid">
            <div class="form-group">
                <label>Course *</label>
                <select name="course" required>
                    <option value="">--</option>
                    <?php foreach(['BCA','BBA','B.Com','BA','BSc','MCA','MBA'] as $c): ?>
                        <option><?= $c ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Year *</label>
                <select name="year" required>
                    <option value="">--</option>
                    <?php foreach(['1st Year','2nd Year','3rd Year','Final Year'] as $y): ?>
                        <option><?= $y ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Day *</label>
                <select name="day_of_week" required>
                    <option value="">--</option>
                    <?php foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $d): ?>
                        <option><?= $d ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group"><label>Period No *</label><input type="number" name="period_no" min="1" max="10" required></div>
            <div class="form-group"><label>Start Time *</label><input type="time" name="start_time" required></div>
            <div class="form-group"><label>End Time *</label><input type="time" name="end_time" required></div>
            <div class="form-group"><label>Subject *</label><input type="text" name="subject" required></div>
            <div class="form-group">
                <label>Teacher</label>
                <select name="teacher_id">
                    <option value="0">-- Select --</option>
                    <?php while($t=$teachers->fetch_assoc()): ?>
                        <option value="<?= $t['id'] ?>"><?= e($t['name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group"><label>Room No</label><input type="text" name="room_no"></div>
        </div>
        <button class="btn">Save Period</button>
        <a href="timetable.php" class="btn btn-light">Cancel</a>
    </form>
</div>

<?php require_once '../includes/teacher_footer.php'; ?>

<?php
$page_title = 'Teacher Dashboard';
require_once '../includes/teacher_header.php';

$students_count = $conn->query("SELECT COUNT(*) c FROM students")->fetch_assoc()['c'];
$notices_count  = $conn->query("SELECT COUNT(*) c FROM notices")->fetch_assoc()['c'];
$exams_count    = $conn->query("SELECT COUNT(*) c FROM examinations WHERE exam_date >= CURDATE()")->fetch_assoc()['c'];
$events_count   = $conn->query("SELECT COUNT(*) c FROM events WHERE event_date >= CURDATE()")->fetch_assoc()['c'];

$recent_students = $conn->query("SELECT * FROM students ORDER BY created_at DESC LIMIT 5");
$recent_notices  = $conn->query("SELECT n.*, t.name AS teacher_name FROM notices n LEFT JOIN teachers t ON n.posted_by=t.id ORDER BY n.created_at DESC LIMIT 5");
?>

<div class="page-header">
    <div>
        <h1>Welcome, <?= e($_SESSION['teacher_name']) ?> 👋</h1>
        <p><?= e($_SESSION['teacher_emp']) ?> · <?= e($_SESSION['teacher_dept']) ?> Department</p>
    </div>
    <div>
        <a href="add_notice.php" class="btn">+ New Notice</a>
        <a href="add_student.php" class="btn btn-secondary">+ Add Student</a>
    </div>
</div>

<div class="cards">
    <div class="card accent"><div class="label">Total Students</div><div class="value"><?= $students_count ?></div><div class="sub"><a href="students.php">Manage →</a></div></div>
    <div class="card success"><div class="label">Active Notices</div><div class="value"><?= $notices_count ?></div><div class="sub"><a href="notices.php">View →</a></div></div>
    <div class="card warning"><div class="label">Upcoming Exams</div><div class="value"><?= $exams_count ?></div><div class="sub"><a href="exams.php">Schedule →</a></div></div>
    <div class="card danger"><div class="label">Upcoming Events</div><div class="value"><?= $events_count ?></div><div class="sub"><a href="events.php">View →</a></div></div>
</div>

<div class="cards" style="grid-template-columns:1fr 1fr;">
    <div class="panel">
        <h3 class="panel-title">Recent Students</h3>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Roll</th><th>Name</th><th>Course</th><th>Year</th></tr></thead>
                <tbody>
                <?php if($recent_students->num_rows): while($s=$recent_students->fetch_assoc()): ?>
                    <tr>
                        <td><?= e($s['roll_no']) ?></td>
                        <td><?= e($s['name']) ?></td>
                        <td><?= e($s['course']) ?></td>
                        <td><?= e($s['year']) ?></td>
                    </tr>
                <?php endwhile; else: ?>
                    <tr><td colspan="4" style="text-align:center; color:#64748b;">No students yet.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="panel">
        <h3 class="panel-title">Recent Notices</h3>
        <?php if($recent_notices->num_rows): while($n=$recent_notices->fetch_assoc()): ?>
            <div class="list-item">
                <h4><?= e($n['title']) ?></h4>
                <p class="meta">By <?= e($n['teacher_name']) ?> · <?= date('d M Y', strtotime($n['created_at'])) ?></p>
            </div>
        <?php endwhile; else: ?>
            <p style="color:#64748b;">No notices.</p>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../includes/teacher_footer.php'; ?>

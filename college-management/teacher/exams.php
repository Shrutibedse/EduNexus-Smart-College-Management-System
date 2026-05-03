<?php
$page_title = 'Examinations';
require_once '../includes/teacher_header.php';

$msg='';
if (isset($_GET['delete'])) {
    $id=(int)$_GET['delete'];
    $del=$conn->prepare("DELETE FROM examinations WHERE id=? AND posted_by=?");
    $del->bind_param('ii', $id, $_SESSION['teacher_id']);
    if ($del->execute() && $del->affected_rows) $msg='Exam deleted.';
    else $msg='You can only delete your own exam entries.';
}

$res = $conn->query("SELECT e.*, t.name AS teacher_name FROM examinations e LEFT JOIN teachers t ON e.posted_by=t.id ORDER BY e.exam_date DESC");
?>

<div class="page-header">
    <div><h1>Examination Schedule</h1></div>
    <a href="add_exam.php" class="btn">+ Add Exam</a>
</div>

<?php if($msg): ?><div class="alert alert-info"><?= e($msg) ?></div><?php endif; ?>

<div class="panel">
    <div class="table-wrap">
        <table>
            <thead><tr><th>#</th><th>Exam</th><th>Course</th><th>Year</th><th>Subject</th><th>Date</th><th>Time</th><th>Duration</th><th>Venue</th><th>Action</th></tr></thead>
            <tbody>
                <?php if($res->num_rows): $i=1; while($r=$res->fetch_assoc()): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= e($r['exam_name']) ?></td>
                        <td><?= e($r['course']) ?></td>
                        <td><?= e($r['year']) ?></td>
                        <td><?= e($r['subject']) ?></td>
                        <td><?= date('d M Y', strtotime($r['exam_date'])) ?></td>
                        <td><?= date('h:i A', strtotime($r['exam_time'])) ?></td>
                        <td><?= e($r['duration']) ?></td>
                        <td><?= e($r['venue']) ?></td>
                        <td><?php if($r['posted_by']==$_SESSION['teacher_id']): ?><a href="?delete=<?= $r['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a><?php endif; ?></td>
                    </tr>
                <?php endwhile; else: ?>
                    <tr><td colspan="10" style="text-align:center; color:#64748b;">No exams added.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../includes/teacher_footer.php'; ?>

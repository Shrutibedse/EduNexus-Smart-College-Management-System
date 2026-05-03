<?php
$page_title = 'Examinations';
require_once '../includes/student_header.php';

$stmt = $conn->prepare("SELECT * FROM examinations WHERE course=? AND year=? ORDER BY exam_date ASC");
$stmt->bind_param('ss', $_SESSION['student_course'], $_SESSION['student_year']);
$stmt->execute();
$res = $stmt->get_result();
?>

<div class="page-header">
    <div>
        <h1>Examination Schedule</h1>
        <p>Upcoming and past exams for <?= e($_SESSION['student_course']) ?> · <?= e($_SESSION['student_year']) ?></p>
    </div>
</div>

<div class="panel">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th><th>Exam Name</th><th>Subject</th><th>Date</th><th>Time</th><th>Duration</th><th>Venue</th><th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if($res->num_rows): $i=1; while($r=$res->fetch_assoc()):
                    $isPast = strtotime($r['exam_date']) < strtotime(date('Y-m-d'));
                ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= e($r['exam_name']) ?></td>
                        <td><?= e($r['subject']) ?></td>
                        <td><?= date('d M Y', strtotime($r['exam_date'])) ?></td>
                        <td><?= date('h:i A', strtotime($r['exam_time'])) ?></td>
                        <td><?= e($r['duration']) ?></td>
                        <td><?= e($r['venue']) ?></td>
                        <td><span class="status <?= $isPast?'paid':'pending' ?>"><?= $isPast?'Completed':'Upcoming' ?></span></td>
                    </tr>
                <?php endwhile; else: ?>
                    <tr><td colspan="8" style="text-align:center; color:#64748b;">No exam scheduled.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../includes/student_footer.php'; ?>

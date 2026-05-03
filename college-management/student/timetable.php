<?php
$page_title = 'Time Table';
require_once '../includes/student_header.php';

$stmt = $conn->prepare("SELECT t.*, te.name AS teacher_name FROM timetable t LEFT JOIN teachers te ON t.teacher_id=te.id WHERE t.course=? AND t.year=? ORDER BY FIELD(t.day_of_week,'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'), t.period_no");
$stmt->bind_param('ss', $_SESSION['student_course'], $_SESSION['student_year']);
$stmt->execute();
$res = $stmt->get_result();

$grouped = [];
while($r = $res->fetch_assoc()) $grouped[$r['day_of_week']][] = $r;

$days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
?>

<div class="page-header">
    <div>
        <h1>Class Time Table</h1>
        <p><?= e($_SESSION['student_course']) ?> · <?= e($_SESSION['student_year']) ?></p>
    </div>
</div>

<?php if(empty($grouped)): ?>
    <div class="panel"><p style="color:#64748b;">No timetable uploaded yet.</p></div>
<?php else: ?>
    <?php foreach($days as $day): if(empty($grouped[$day])) continue; ?>
        <div class="panel">
            <h3 class="panel-title"><?= $day ?></h3>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr><th>Period</th><th>Time</th><th>Subject</th><th>Teacher</th><th>Room</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach($grouped[$day] as $p): ?>
                            <tr>
                                <td><?= e($p['period_no']) ?></td>
                                <td><?= date('h:i A', strtotime($p['start_time'])) ?> - <?= date('h:i A', strtotime($p['end_time'])) ?></td>
                                <td><?= e($p['subject']) ?></td>
                                <td><?= e($p['teacher_name'] ?? '-') ?></td>
                                <td><?= e($p['room_no']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php require_once '../includes/student_footer.php'; ?>

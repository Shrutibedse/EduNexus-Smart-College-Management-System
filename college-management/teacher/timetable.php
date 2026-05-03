<?php
$page_title = 'Time Table';
require_once '../includes/teacher_header.php';

$msg='';
if (isset($_GET['delete'])) {
    $id=(int)$_GET['delete'];
    $del=$conn->prepare("DELETE FROM timetable WHERE id=?");
    $del->bind_param('i', $id);
    if ($del->execute()) $msg='Period deleted.';
}

$courseF = $_GET['course'] ?? 'BCA';
$yearF   = $_GET['year']   ?? '1st Year';

$stmt = $conn->prepare("SELECT t.*, te.name AS teacher_name FROM timetable t LEFT JOIN teachers te ON t.teacher_id=te.id WHERE t.course=? AND t.year=? ORDER BY FIELD(t.day_of_week,'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'), t.period_no");
$stmt->bind_param('ss', $courseF, $yearF);
$stmt->execute();
$res = $stmt->get_result();
$grouped=[];
while($r=$res->fetch_assoc()) $grouped[$r['day_of_week']][]=$r;
$days=['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
?>

<div class="page-header">
    <div><h1>Time Table</h1></div>
    <a href="add_timetable.php" class="btn">+ Add Period</a>
</div>

<?php if($msg): ?><div class="alert alert-success"><?= e($msg) ?></div><?php endif; ?>

<div class="panel">
    <form method="GET" style="display:flex; gap:10px; margin-bottom:18px; flex-wrap:wrap;">
        <select name="course" style="padding:10px; border:1px solid #e2e8f0; border-radius:6px;">
            <?php foreach(['BCA','BBA','B.Com','BA','BSc','MCA','MBA'] as $c): ?>
                <option <?= $courseF===$c?'selected':'' ?>><?= $c ?></option>
            <?php endforeach; ?>
        </select>
        <select name="year" style="padding:10px; border:1px solid #e2e8f0; border-radius:6px;">
            <?php foreach(['1st Year','2nd Year','3rd Year','Final Year'] as $y): ?>
                <option <?= $yearF===$y?'selected':'' ?>><?= $y ?></option>
            <?php endforeach; ?>
        </select>
        <button class="btn">View</button>
    </form>

    <?php if(empty($grouped)): ?>
        <p style="color:#64748b;">No timetable for <?= e($courseF) ?> · <?= e($yearF) ?></p>
    <?php else: foreach($days as $day): if(empty($grouped[$day])) continue; ?>
        <h3 style="color:#1e3a8a; margin-top:14px;"><?= $day ?></h3>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Period</th><th>Time</th><th>Subject</th><th>Teacher</th><th>Room</th><th>Action</th></tr></thead>
                <tbody>
                    <?php foreach($grouped[$day] as $p): ?>
                    <tr>
                        <td><?= e($p['period_no']) ?></td>
                        <td><?= date('h:i A', strtotime($p['start_time'])) ?> - <?= date('h:i A', strtotime($p['end_time'])) ?></td>
                        <td><?= e($p['subject']) ?></td>
                        <td><?= e($p['teacher_name'] ?? '-') ?></td>
                        <td><?= e($p['room_no']) ?></td>
                        <td><a href="?delete=<?= $p['id'] ?>&course=<?= urlencode($courseF) ?>&year=<?= urlencode($yearF) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; endif; ?>
</div>

<?php require_once '../includes/teacher_footer.php'; ?>

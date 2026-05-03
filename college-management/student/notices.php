<?php
$page_title = 'Notices';
require_once '../includes/student_header.php';

$res = $conn->query("SELECT n.*, t.name AS teacher_name FROM notices n LEFT JOIN teachers t ON n.posted_by=t.id WHERE n.target_audience IN ('All','Students') ORDER BY n.created_at DESC");
?>

<div class="page-header">
    <div>
        <h1>Notices</h1>
        <p>Latest college announcements</p>
    </div>
</div>

<div class="panel">
    <?php if($res->num_rows): while($n=$res->fetch_assoc()): ?>
        <div class="list-item">
            <h4><?= e($n['title']) ?></h4>
            <p class="meta">By <?= e($n['teacher_name']) ?> · <?= date('d M Y, h:i A', strtotime($n['created_at'])) ?></p>
            <p><?= nl2br(e($n['description'])) ?></p>
        </div>
    <?php endwhile; else: ?>
        <p style="color:#64748b;">No notices yet.</p>
    <?php endif; ?>
</div>

<?php require_once '../includes/student_footer.php'; ?>

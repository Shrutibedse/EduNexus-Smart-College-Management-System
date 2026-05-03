<?php
$page_title = 'Notices';
require_once '../includes/teacher_header.php';

$msg='';
if (isset($_GET['delete'])) {
    $id=(int)$_GET['delete'];
    $del = $conn->prepare("DELETE FROM notices WHERE id=? AND posted_by=?");
    $del->bind_param('ii', $id, $_SESSION['teacher_id']);
    if ($del->execute() && $del->affected_rows) $msg='Notice deleted.';
    else $msg='You can only delete your own notices.';
}

$res = $conn->query("SELECT n.*, t.name AS teacher_name FROM notices n LEFT JOIN teachers t ON n.posted_by=t.id ORDER BY n.created_at DESC");
?>

<div class="page-header">
    <div><h1>All Notices</h1></div>
    <a href="add_notice.php" class="btn">+ Add Notice</a>
</div>

<?php if($msg): ?><div class="alert alert-info"><?= e($msg) ?></div><?php endif; ?>

<div class="panel">
    <?php if($res->num_rows): while($n=$res->fetch_assoc()): ?>
        <div class="list-item">
            <h4><?= e($n['title']) ?></h4>
            <p class="meta">
                By <?= e($n['teacher_name']) ?> ·
                <?= date('d M Y, h:i A', strtotime($n['created_at'])) ?> ·
                Audience: <strong><?= e($n['target_audience']) ?></strong>
                <?php if($n['course']): ?> · <?= e($n['course']) ?><?php endif; ?>
            </p>
            <p><?= nl2br(e($n['description'])) ?></p>
            <?php if($n['posted_by']==$_SESSION['teacher_id']): ?>
                <p style="margin-top:8px;"><a href="?delete=<?= $n['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a></p>
            <?php endif; ?>
        </div>
    <?php endwhile; else: ?>
        <p style="color:#64748b;">No notices yet.</p>
    <?php endif; ?>
</div>

<?php require_once '../includes/teacher_footer.php'; ?>

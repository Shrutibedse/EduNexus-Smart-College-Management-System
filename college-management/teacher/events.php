<?php
$page_title = 'Events';
require_once '../includes/teacher_header.php';

$msg='';
if (isset($_GET['delete'])) {
    $id=(int)$_GET['delete'];
    $del=$conn->prepare("DELETE FROM events WHERE id=? AND posted_by=?");
    $del->bind_param('ii', $id, $_SESSION['teacher_id']);
    if ($del->execute() && $del->affected_rows) $msg='Event deleted.';
    else $msg='You can only delete your own events.';
}

$res = $conn->query("SELECT e.*, t.name AS teacher_name FROM events e LEFT JOIN teachers t ON e.posted_by=t.id ORDER BY e.event_date DESC");
?>

<div class="page-header">
    <div><h1>Events</h1></div>
    <a href="add_event.php" class="btn">+ Add Event</a>
</div>

<?php if($msg): ?><div class="alert alert-info"><?= e($msg) ?></div><?php endif; ?>

<div class="panel">
    <?php if($res->num_rows): while($ev=$res->fetch_assoc()):
        $isUp = strtotime($ev['event_date']) >= strtotime(date('Y-m-d'));
    ?>
        <div class="list-item event">
            <h4><?= e($ev['title']) ?>
                <span class="status <?= $isUp?'pending':'paid' ?>" style="margin-left:8px;"><?= $isUp?'Upcoming':'Past' ?></span>
            </h4>
            <p class="meta">
                📅 <?= date('d M Y', strtotime($ev['event_date'])) ?>
                <?php if(!empty($ev['event_time'])): ?> · ⏰ <?= date('h:i A', strtotime($ev['event_time'])) ?><?php endif; ?>
                · 📍 <?= e($ev['venue']) ?> · By <?= e($ev['teacher_name']) ?>
            </p>
            <p><?= nl2br(e($ev['description'])) ?></p>
            <?php if($ev['posted_by']==$_SESSION['teacher_id']): ?>
                <p style="margin-top:8px;"><a href="?delete=<?= $ev['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a></p>
            <?php endif; ?>
        </div>
    <?php endwhile; else: ?>
        <p style="color:#64748b;">No events.</p>
    <?php endif; ?>
</div>

<?php require_once '../includes/teacher_footer.php'; ?>

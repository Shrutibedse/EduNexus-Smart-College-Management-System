<?php
$page_title = 'Events';
require_once '../includes/student_header.php';

$res = $conn->query("SELECT e.*, t.name AS teacher_name FROM events e LEFT JOIN teachers t ON e.posted_by=t.id ORDER BY e.event_date DESC");
?>

<div class="page-header">
    <div>
        <h1>Events</h1>
        <p>Upcoming and recent college events</p>
    </div>
</div>

<div class="panel">
    <?php if($res->num_rows): while($ev=$res->fetch_assoc()):
        $isUpcoming = strtotime($ev['event_date']) >= strtotime(date('Y-m-d'));
    ?>
        <div class="list-item event">
            <h4><?= e($ev['title']) ?>
                <span class="status <?= $isUpcoming?'pending':'paid' ?>" style="margin-left:8px;">
                    <?= $isUpcoming?'Upcoming':'Past' ?>
                </span>
            </h4>
            <p class="meta">
                📅 <?= date('d M Y', strtotime($ev['event_date'])) ?>
                <?php if(!empty($ev['event_time'])): ?> · ⏰ <?= date('h:i A', strtotime($ev['event_time'])) ?><?php endif; ?>
                · 📍 <?= e($ev['venue']) ?> · Posted by <?= e($ev['teacher_name']) ?>
            </p>
            <p><?= nl2br(e($ev['description'])) ?></p>
        </div>
    <?php endwhile; else: ?>
        <p style="color:#64748b;">No events posted.</p>
    <?php endif; ?>
</div>

<?php require_once '../includes/student_footer.php'; ?>

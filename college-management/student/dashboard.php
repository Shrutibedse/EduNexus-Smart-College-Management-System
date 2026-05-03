<?php
$page_title = 'Dashboard';
require_once '../includes/student_header.php';

$sid = $_SESSION['student_id'];

// Stats
$pending_fees_q = $conn->prepare("SELECT IFNULL(SUM(amount-paid_amount),0) AS due FROM fees WHERE student_id=? AND status<>'Paid'");
$pending_fees_q->bind_param('i', $sid); $pending_fees_q->execute();
$pending_fees = $pending_fees_q->get_result()->fetch_assoc()['due'];

$exam_count = $conn->query("SELECT COUNT(*) AS c FROM examinations WHERE course='".$conn->real_escape_string($_SESSION['student_course'])."' AND year='".$conn->real_escape_string($_SESSION['student_year'])."' AND exam_date >= CURDATE()")->fetch_assoc()['c'];

$notice_count = $conn->query("SELECT COUNT(*) AS c FROM notices WHERE target_audience IN ('All','Students')")->fetch_assoc()['c'];

$event_count = $conn->query("SELECT COUNT(*) AS c FROM events WHERE event_date >= CURDATE()")->fetch_assoc()['c'];

// Latest notices
$notices = $conn->query("SELECT n.*, t.name AS teacher_name FROM notices n LEFT JOIN teachers t ON n.posted_by=t.id WHERE n.target_audience IN ('All','Students') ORDER BY n.created_at DESC LIMIT 5");

// Upcoming exams
$exams = $conn->prepare("SELECT * FROM examinations WHERE course=? AND year=? AND exam_date >= CURDATE() ORDER BY exam_date ASC LIMIT 5");
$exams->bind_param('ss', $_SESSION['student_course'], $_SESSION['student_year']);
$exams->execute();
$exams = $exams->get_result();
?>

<div class="page-header">
    <div>
        <h1>Welcome, <?= e($_SESSION['student_name']) ?> 👋</h1>
        <p>Roll: <?= e($_SESSION['student_roll']) ?> · <?= e($_SESSION['student_course']) ?> · <?= e($_SESSION['student_year']) ?></p>
    </div>
</div>

<div class="cards">
    <div class="card danger">
        <div class="label">Pending Fees</div>
        <div class="value">₹<?= number_format($pending_fees, 0) ?></div>
        <div class="sub"><a href="fees.php">View details →</a></div>
    </div>
    <div class="card warning">
        <div class="label">Upcoming Exams</div>
        <div class="value"><?= $exam_count ?></div>
        <div class="sub"><a href="examination.php">View schedule →</a></div>
    </div>
    <div class="card accent">
        <div class="label">Active Notices</div>
        <div class="value"><?= $notice_count ?></div>
        <div class="sub"><a href="notices.php">Read notices →</a></div>
    </div>
    <div class="card success">
        <div class="label">Upcoming Events</div>
        <div class="value"><?= $event_count ?></div>
        <div class="sub"><a href="events.php">Browse events →</a></div>
    </div>
</div>

<div class="cards" style="grid-template-columns:1fr 1fr;">
    <div class="panel">
        <h3 class="panel-title">Latest Notices</h3>
        <?php if($notices->num_rows): while($n=$notices->fetch_assoc()): ?>
            <div class="list-item">
                <h4><?= e($n['title']) ?></h4>
                <p class="meta">By <?= e($n['teacher_name']) ?> · <?= date('d M Y', strtotime($n['created_at'])) ?></p>
                <p><?= e(substr($n['description'],0,150)) ?>...</p>
            </div>
        <?php endwhile; else: ?>
            <p style="color:#64748b;">No notices.</p>
        <?php endif; ?>
    </div>

    <div class="panel">
        <h3 class="panel-title">Upcoming Examinations</h3>
        <?php if($exams->num_rows): while($ex=$exams->fetch_assoc()): ?>
            <div class="list-item event">
                <h4><?= e($ex['subject']) ?> — <?= e($ex['exam_name']) ?></h4>
                <p class="meta">📅 <?= date('d M Y', strtotime($ex['exam_date'])) ?> at <?= date('h:i A', strtotime($ex['exam_time'])) ?></p>
                <p>Duration: <?= e($ex['duration']) ?> · Venue: <?= e($ex['venue']) ?></p>
            </div>
        <?php endwhile; else: ?>
            <p style="color:#64748b;">No upcoming exams.</p>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../includes/student_footer.php'; ?>

<?php
$page_title = 'Add Event';
require_once '../includes/teacher_header.php';

$msg=''; $err='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $title=trim($_POST['title']??''); $desc=trim($_POST['description']??'');
    $date=$_POST['event_date']??''; $time=$_POST['event_time']??null;
    $venue=trim($_POST['venue']??'');
    if (!$title || !$desc || !$date) $err='Title, description and date are required.';
    else {
        $stmt = $conn->prepare("INSERT INTO events (title,description,event_date,event_time,venue,posted_by) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param('sssssi', $title,$desc,$date,$time,$venue,$_SESSION['teacher_id']);
        if ($stmt->execute()) { $msg='Event added.'; $_POST=[]; }
        else $err='Failed: '.$conn->error;
    }
}
?>

<div class="page-header"><h1>Add Event</h1></div>

<?php if($msg): ?><div class="alert alert-success"><?= e($msg) ?> <a href="events.php">View →</a></div><?php endif; ?>
<?php if($err): ?><div class="alert alert-danger"><?= e($err) ?></div><?php endif; ?>

<div class="panel">
    <form method="POST">
        <div class="form-group"><label>Event Title *</label><input type="text" name="title" required value="<?= e($_POST['title'] ?? '') ?>"></div>
        <div class="form-group"><label>Description *</label><textarea name="description" rows="5" required><?= e($_POST['description'] ?? '') ?></textarea></div>
        <div class="form-grid">
            <div class="form-group"><label>Event Date *</label><input type="date" name="event_date" required value="<?= e($_POST['event_date'] ?? '') ?>"></div>
            <div class="form-group"><label>Event Time</label><input type="time" name="event_time" value="<?= e($_POST['event_time'] ?? '') ?>"></div>
            <div class="form-group" style="grid-column:span 2;"><label>Venue</label><input type="text" name="venue" value="<?= e($_POST['venue'] ?? '') ?>"></div>
        </div>
        <button class="btn">Save Event</button>
        <a href="events.php" class="btn btn-light">Cancel</a>
    </form>
</div>

<?php require_once '../includes/teacher_footer.php'; ?>

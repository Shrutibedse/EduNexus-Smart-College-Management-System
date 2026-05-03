<?php
$page_title = 'Add Notice';
require_once '../includes/teacher_header.php';

$msg=''; $err='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $title=trim($_POST['title']??'');
    $desc=trim($_POST['description']??'');
    $aud=$_POST['target_audience']??'All';
    $course=$_POST['course']??null;
    if (!$title || !$desc) $err='Title and description are required.';
    else {
        $stmt = $conn->prepare("INSERT INTO notices (title,description,target_audience,course,posted_by) VALUES (?,?,?,?,?)");
        $stmt->bind_param('ssssi', $title,$desc,$aud,$course,$_SESSION['teacher_id']);
        if ($stmt->execute()) { $msg='Notice posted.'; $_POST=[]; }
        else $err='Failed: '.$conn->error;
    }
}
?>

<div class="page-header"><h1>Add Notice</h1></div>

<?php if($msg): ?><div class="alert alert-success"><?= e($msg) ?> <a href="notices.php">View all →</a></div><?php endif; ?>
<?php if($err): ?><div class="alert alert-danger"><?= e($err) ?></div><?php endif; ?>

<div class="panel">
    <form method="POST">
        <div class="form-group"><label>Title *</label><input type="text" name="title" required value="<?= e($_POST['title'] ?? '') ?>"></div>
        <div class="form-group"><label>Description *</label><textarea name="description" rows="6" required><?= e($_POST['description'] ?? '') ?></textarea></div>
        <div class="form-grid">
            <div class="form-group">
                <label>Target Audience</label>
                <select name="target_audience">
                    <option value="All">All</option>
                    <option value="Students">Students Only</option>
                    <option value="Teachers">Teachers Only</option>
                </select>
            </div>
            <div class="form-group">
                <label>Specific Course (optional)</label>
                <select name="course">
                    <option value="">-- Any --</option>
                    <?php foreach(['BCA','BBA','B.Com','BA','BSc','MCA','MBA'] as $c): ?>
                        <option><?= $c ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <button class="btn">Post Notice</button>
        <a href="notices.php" class="btn btn-light">Cancel</a>
    </form>
</div>

<?php require_once '../includes/teacher_footer.php'; ?>

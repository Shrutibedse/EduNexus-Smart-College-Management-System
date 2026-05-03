<?php
$page_title = 'Students';
require_once '../includes/teacher_header.php';

$msg='';
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $del = $conn->prepare("DELETE FROM students WHERE id=?");
    $del->bind_param('i', $id);
    if ($del->execute()) $msg='Student deleted.';
}

$search = trim($_GET['q'] ?? '');
$courseF= trim($_GET['course'] ?? '');

$where=[]; $params=[]; $types='';
if ($search) { $where[]="(name LIKE ? OR roll_no LIKE ? OR email LIKE ?)"; $like="%$search%"; $params[]=$like;$params[]=$like;$params[]=$like; $types.='sss'; }
if ($courseF){ $where[]="course=?"; $params[]=$courseF; $types.='s'; }
$sql = "SELECT * FROM students" . ($where ? " WHERE ".implode(' AND ',$where) : "") . " ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$res = $stmt->get_result();
?>

<div class="page-header">
    <div>
        <h1>Students</h1>
        <p>All registered students</p>
    </div>
    <a href="add_student.php" class="btn">+ Add Student</a>
</div>

<?php if($msg): ?><div class="alert alert-success"><?= e($msg) ?></div><?php endif; ?>

<div class="panel">
    <form method="GET" style="display:flex; gap:10px; margin-bottom:18px; flex-wrap:wrap;">
        <input type="text" name="q" placeholder="Search by name, roll, email" value="<?= e($search) ?>" style="flex:1; min-width:200px; padding:10px; border:1px solid #e2e8f0; border-radius:6px;">
        <select name="course" style="padding:10px; border:1px solid #e2e8f0; border-radius:6px;">
            <option value="">All Courses</option>
            <?php foreach(['BCA','BBA','B.Com','BA','BSc','MCA','MBA'] as $c): ?>
                <option <?= $courseF===$c?'selected':'' ?>><?= $c ?></option>
            <?php endforeach; ?>
        </select>
        <button class="btn">Filter</button>
        <a href="students.php" class="btn btn-light">Reset</a>
    </form>

    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>#</th><th>Roll</th><th>Name</th><th>Email</th><th>Phone</th><th>Course</th><th>Year</th><th>Action</th></tr>
            </thead>
            <tbody>
                <?php if($res->num_rows): $i=1; while($s=$res->fetch_assoc()): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= e($s['roll_no']) ?></td>
                        <td><?= e($s['name']) ?></td>
                        <td><?= e($s['email']) ?></td>
                        <td><?= e($s['phone']) ?></td>
                        <td><?= e($s['course']) ?></td>
                        <td><?= e($s['year']) ?></td>
                        <td>
                            <a href="view_student.php?id=<?= $s['id'] ?>" class="btn btn-sm btn-light">View</a>
                            <a href="?delete=<?= $s['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this student?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; else: ?>
                    <tr><td colspan="8" style="text-align:center; color:#64748b;">No students found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../includes/teacher_footer.php'; ?>

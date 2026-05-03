<?php
$page_title = 'Fees Records';
require_once '../includes/teacher_header.php';

$msg='';
if ($_SERVER['REQUEST_METHOD']==='POST' && ($_POST['action'] ?? '')==='add') {
    $sid=(int)($_POST['student_id']??0);
    $type=trim($_POST['fee_type']??'');
    $amount=(float)($_POST['amount']??0);
    $paid=(float)($_POST['paid_amount']??0);
    $due=$_POST['due_date']??null;
    $status = $paid >= $amount ? 'Paid' : ($paid>0 ? 'Partial' : 'Pending');
    if (!$sid || !$type || $amount<=0) $msg='Please fill student, fee type and amount.';
    else {
        $stmt = $conn->prepare("INSERT INTO fees (student_id,fee_type,amount,paid_amount,due_date,status) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param('isddss', $sid,$type,$amount,$paid,$due,$status);
        if ($stmt->execute()) $msg='Fee record added.';
        else $msg='Failed: '.$conn->error;
    }
}

if (isset($_GET['delete'])) {
    $id=(int)$_GET['delete'];
    $conn->query("DELETE FROM fees WHERE id=$id");
    $msg='Record deleted.';
}

$students = $conn->query("SELECT id,roll_no,name FROM students ORDER BY name");
$res = $conn->query("SELECT f.*, s.name AS student_name, s.roll_no FROM fees f JOIN students s ON f.student_id=s.id ORDER BY f.created_at DESC");
?>

<div class="page-header">
    <div><h1>Fees Records</h1></div>
</div>

<?php if($msg): ?><div class="alert alert-info"><?= e($msg) ?></div><?php endif; ?>

<div class="panel">
    <h3 class="panel-title">Add Fee Entry</h3>
    <form method="POST">
        <input type="hidden" name="action" value="add">
        <div class="form-grid">
            <div class="form-group">
                <label>Student *</label>
                <select name="student_id" required>
                    <option value="">--</option>
                    <?php while($s=$students->fetch_assoc()): ?>
                        <option value="<?= $s['id'] ?>"><?= e($s['roll_no']) ?> - <?= e($s['name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group"><label>Fee Type *</label><input type="text" name="fee_type" required placeholder="e.g. Tuition Fee Sem 1"></div>
            <div class="form-group"><label>Amount *</label><input type="number" step="0.01" name="amount" required></div>
            <div class="form-group"><label>Paid Amount</label><input type="number" step="0.01" name="paid_amount" value="0"></div>
            <div class="form-group"><label>Due Date</label><input type="date" name="due_date"></div>
        </div>
        <button class="btn">Add Fee</button>
    </form>
</div>

<div class="panel">
    <h3 class="panel-title">All Fee Records</h3>
    <div class="table-wrap">
        <table>
            <thead><tr><th>#</th><th>Student</th><th>Roll</th><th>Fee Type</th><th>Amount</th><th>Paid</th><th>Due Date</th><th>Status</th><th>Action</th></tr></thead>
            <tbody>
                <?php if($res->num_rows): $i=1; while($r=$res->fetch_assoc()): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= e($r['student_name']) ?></td>
                        <td><?= e($r['roll_no']) ?></td>
                        <td><?= e($r['fee_type']) ?></td>
                        <td>₹<?= number_format($r['amount'],0) ?></td>
                        <td>₹<?= number_format($r['paid_amount'],0) ?></td>
                        <td><?= $r['due_date']?date('d M Y', strtotime($r['due_date'])):'-' ?></td>
                        <td><span class="status <?= strtolower($r['status']) ?>"><?= e($r['status']) ?></span></td>
                        <td><a href="?delete=<?= $r['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a></td>
                    </tr>
                <?php endwhile; else: ?>
                    <tr><td colspan="9" style="text-align:center; color:#64748b;">No records.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../includes/teacher_footer.php'; ?>

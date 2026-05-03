<?php
$page_title = 'Student Details';
require_once '../includes/teacher_header.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $conn->prepare("SELECT * FROM students WHERE id=?");
$stmt->bind_param('i', $id); $stmt->execute();
$s = $stmt->get_result()->fetch_assoc();
if (!$s) { echo '<div class="alert alert-danger">Student not found.</div>'; require_once '../includes/teacher_footer.php'; exit; }

$fees = $conn->prepare("SELECT * FROM fees WHERE student_id=? ORDER BY created_at DESC");
$fees->bind_param('i', $id); $fees->execute(); $fees=$fees->get_result();
?>

<div class="page-header">
    <div>
        <h1><?= e($s['name']) ?></h1>
        <p><?= e($s['roll_no']) ?> · <?= e($s['course']) ?> · <?= e($s['year']) ?></p>
    </div>
    <a href="students.php" class="btn btn-light">← Back</a>
</div>

<div class="panel">
    <h3 class="panel-title">Personal Information</h3>
    <div class="form-grid">
        <div><strong>Email:</strong><br><?= e($s['email']) ?></div>
        <div><strong>Phone:</strong><br><?= e($s['phone']) ?></div>
        <div><strong>Date of Birth:</strong><br><?= e($s['dob']) ?></div>
        <div><strong>Gender:</strong><br><?= e($s['gender']) ?></div>
        <div style="grid-column:span 2;"><strong>Address:</strong><br><?= nl2br(e($s['address'])) ?></div>
    </div>
</div>

<div class="panel">
    <h3 class="panel-title">Fee Records</h3>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Fee Type</th><th>Amount</th><th>Paid</th><th>Status</th></tr></thead>
            <tbody>
                <?php if($fees->num_rows): while($f=$fees->fetch_assoc()): ?>
                    <tr>
                        <td><?= e($f['fee_type']) ?></td>
                        <td>₹<?= number_format($f['amount'],0) ?></td>
                        <td>₹<?= number_format($f['paid_amount'],0) ?></td>
                        <td><span class="status <?= strtolower($f['status']) ?>"><?= e($f['status']) ?></span></td>
                    </tr>
                <?php endwhile; else: ?>
                    <tr><td colspan="4" style="text-align:center; color:#64748b;">No fees added.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../includes/teacher_footer.php'; ?>

<?php
$page_title = 'Fees';
require_once '../includes/student_header.php';
$sid = $_SESSION['student_id'];

$stmt = $conn->prepare("SELECT * FROM fees WHERE student_id=? ORDER BY created_at DESC");
$stmt->bind_param('i', $sid); $stmt->execute();
$res = $stmt->get_result();

$total = 0; $paid = 0;
$rows = [];
while($r = $res->fetch_assoc()) { $rows[]=$r; $total+=$r['amount']; $paid+=$r['paid_amount']; }
$pending = $total - $paid;
?>

<div class="page-header">
    <div>
        <h1>Fees</h1>
        <p>Your fee statement and payment history</p>
    </div>
</div>

<div class="cards">
    <div class="card success">
        <div class="label">Total Fees</div>
        <div class="value">₹<?= number_format($total,0) ?></div>
    </div>
    <div class="card accent">
        <div class="label">Paid</div>
        <div class="value">₹<?= number_format($paid,0) ?></div>
    </div>
    <div class="card danger">
        <div class="label">Pending</div>
        <div class="value">₹<?= number_format($pending,0) ?></div>
    </div>
</div>

<div class="panel">
    <h3 class="panel-title">Fee Records</h3>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th><th>Fee Type</th><th>Amount</th><th>Paid</th><th>Balance</th><th>Due Date</th><th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if($rows): foreach($rows as $i=>$r): $bal=$r['amount']-$r['paid_amount']; ?>
                    <tr>
                        <td><?= $i+1 ?></td>
                        <td><?= e($r['fee_type']) ?></td>
                        <td>₹<?= number_format($r['amount'],0) ?></td>
                        <td>₹<?= number_format($r['paid_amount'],0) ?></td>
                        <td>₹<?= number_format($bal,0) ?></td>
                        <td><?= $r['due_date'] ? date('d M Y', strtotime($r['due_date'])) : '-' ?></td>
                        <td><span class="status <?= strtolower($r['status']) ?>"><?= e($r['status']) ?></span></td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="7" style="text-align:center; color:#64748b;">No fee records.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../includes/student_footer.php'; ?>

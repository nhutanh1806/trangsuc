<?php
require_once '../php/config.php';

if (!isset($_GET['user_id'])) {
    die("Thiếu ID người dùng.");
}

$user_id = intval($_GET['user_id']);

// Lấy thông tin user
$stmt_user = $pdo->prepare("SELECT username, fullname, email FROM users WHERE id = ?");
$stmt_user->execute([$user_id]);
$user = $stmt_user->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Không tìm thấy người dùng.");
}

// ✅ Lấy danh sách đơn hàng của user (dùng bảng orthers & orther_items)
$stmt_orders = $pdo->prepare("
    SELECT 
        o.id, 
        o.user_id, 
        o.order_date, 
        o.status, 
        o.address, 
        o.phone, 
        o.note,
        COALESCE(SUM(oi.quantity * p.price), 0) AS total_amount
    FROM orthers o
    LEFT JOIN orther_items oi ON oi.order_id = o.id
    LEFT JOIN products p ON oi.product_id = p.id
    WHERE o.user_id = ?
    GROUP BY o.id
    ORDER BY o.order_date DESC
");

$stmt_orders->execute([$user_id]);
$orders = $stmt_orders->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Lịch sử đơn hàng - <?= htmlspecialchars($user['fullname']) ?></title>
<style>
    body { font-family: Arial, sans-serif; background:#f6f6f6; margin:0; padding:20px;}
    h2 { text-align:center; color:#333;}
    table { width:100%; border-collapse:collapse; background:white; border-radius:8px; overflow:hidden;}
    th, td { padding:12px 15px; border-bottom:1px solid #eee;}
    th { background:#007bff; color:white;}
    tr:hover { background:#f1f1f1;}
    a.back { display:inline-block; margin-bottom:15px; text-decoration:none; color:#007bff;}
</style>
</head>
<body>
<a href="admin_quanlynguoidung.php" class="back">← Quay lại danh sách khách hàng</a>
<h2>Đơn hàng của: <?= htmlspecialchars($user['fullname']) ?> (<?= htmlspecialchars($user['email']) ?>)</h2>

<table>
    <tr>
        <th>ID đơn hàng</th>
        <th>Tổng tiền</th>
        <th>Trạng thái</th>
        <th>Ngày đặt</th>
        <th>Địa chỉ</th>
        <th>Điện thoại</th>
        <th>Ghi chú</th>
    </tr>
    <?php if ($orders): ?>
        <?php foreach ($orders as $o): ?>
        <tr>
            <td><?= $o['id'] ?></td>
            <td><?= number_format($o['total_amount'], 0, ',', '.') ?> ₫</td>
            <td><?= htmlspecialchars($o['status']) ?></td>
            <td><?= htmlspecialchars($o['order_date']) ?></td>
            <td><?= htmlspecialchars($o['address']) ?></td>
            <td><?= htmlspecialchars($o['phone']) ?></td>
            <td><?= htmlspecialchars($o['note']) ?></td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="7" style="text-align:center;">Người dùng này chưa có đơn hàng.</td></tr>
    <?php endif; ?>
</table>
</body>
</html>

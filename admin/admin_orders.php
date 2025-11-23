<?php
session_start();
require_once '../php/config.php';

// Kiểm tra quyền admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit;
}

// Cập nhật trạng thái đơn hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['status'])) {
    $stmt = $pdo->prepare("UPDATE orthers SET status = ? WHERE id = ?");
    $stmt->execute([$_POST['status'], $_POST['order_id']]);
    header("Location: admin_orders.php?message=" . urlencode("Cập nhật trạng thái thành công."));
    exit;
}

// Lấy danh sách đơn hàng và tổng tiền chính xác từ products
$stmt = $pdo->query("
    SELECT o.id, o.user_id, o.order_date, o.status, u.username,
           COALESCE(SUM(oi.quantity * p.price),0) as total
    FROM orthers o
    LEFT JOIN orther_items oi ON oi.order_id = o.id
    LEFT JOIN products p ON oi.product_id = p.id
    LEFT JOIN users u ON u.id = o.user_id
    GROUP BY o.id
    ORDER BY o.order_date DESC
");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý đơn hàng</title>
<style>
body { font-family: Arial; background: #f7f7f7; padding: 40px; }
table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; }
th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
th { background: #0ABAB5; color: white; }
button { background: #007bff; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; }
button:hover { background: #0056b3; }
a { text-decoration: none; }
.status { font-weight: bold; }
</style>
</head>
<body>

<?php if (isset($_GET['message'])): ?>
<div style="background:#d4edda; color:#155724; padding:10px; margin-bottom:10px; border-radius:5px;">
  ✅ <?= htmlspecialchars($_GET['message']); ?>
</div>
<?php endif; ?>

<h2>📦 Danh sách đơn hàng</h2>

<table>
<tr>
  <th>Xóa</th>
  <th>ID</th>
  <th>Người dùng</th>
  <th>Ngày đặt</th>
  <th>Tổng tiền (VND)</th>
  <th>Trạng thái</th>
  <th>Hành động</th>
</tr>

<?php if(count($orders) > 0): ?>
  <?php foreach($orders as $order): ?>
<tr>
  <td>
    <a href="admin_delete_order.php?id=<?= $order['id']; ?>"
       onclick="return confirm('Bạn có chắc muốn xóa đơn hàng này không?');"
       style="color:#dc3545; font-weight:bold;">X</a>
  </td>
  <td><?= $order['id']; ?></td>
  <td><?= htmlspecialchars($order['username'] ?? ''); ?></td>
  <td><?= $order['order_date']; ?></td>
  <td><?= number_format(floatval($order['total']), 0, ',', '.'); ?></td>
  <td class="status"><?= htmlspecialchars($order['status']); ?></td>
  <td>
    <form method="post" style="display:inline;">
      <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
      <select name="status">
        <option value="pending" <?= $order['status']=='pending'?'selected':''; ?>>Chờ xử lý</option>
        <option value="processing" <?= $order['status']=='processing'?'selected':''; ?>>Đang xử lý</option>
        <option value="completed" <?= $order['status']=='completed'?'selected':''; ?>>Hoàn thành</option>
        <option value="cancelled" <?= $order['status']=='cancelled'?'selected':''; ?>>Đã hủy</option>
      </select>
      <button type="submit">Cập nhật</button>
    </form>
    <a href="admin_order_detail.php?id=<?= $order['id']; ?>" style="margin-left:8px;">Chi tiết</a>
  </td>
</tr>
  <?php endforeach; ?>
<?php else: ?>
<tr><td colspan="7" style="text-align:center; color:#888;">Chưa có đơn hàng nào.</td></tr>
<?php endif; ?>
</table>

<a href="admin_dashboard.php">← Quay lại trang chủ</a>

</body>
</html>

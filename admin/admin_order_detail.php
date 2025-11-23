<?php
session_start();
require_once '../php/config.php';

// Kiểm tra quyền admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit;
}

// Lấy ID đơn hàng từ URL
if (!isset($_GET['id'])) {
    echo "Thiếu ID đơn hàng.";
    exit;
}

$order_id = $_GET['id'];

// Lấy thông tin đơn hàng
$stmt = $pdo->prepare("SELECT * FROM orthers WHERE id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo "Không tìm thấy đơn hàng.";
    exit;
}

// Lấy danh sách sản phẩm trong đơn
$stmtItems = $pdo->prepare("
    SELECT p.name AS product_name, p.price, i.quantity AS qty
    FROM orther_items i
    JOIN products p ON i.product_id = p.id
    WHERE i.order_id = ?
");


$stmtItems->execute([$order_id]);
$items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

// Tính tổng tiền trực tiếp từ chi tiết sản phẩm
$totalAmount = 0;
foreach ($items as $item) {
    $totalAmount += $item['price'] * $item['qty'];
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Chi tiết đơn hàng #<?php echo $order_id; ?></title>
<style>
body { font-family: Arial; background: #f4f4f4; padding: 40px; }
h1 { color: #0ABAB5; }
.table, th, td { border: 1px solid #ddd; border-collapse: collapse; }
.table { width: 100%; background: white; margin-top: 20px; }
th, td { padding: 10px; text-align: center; }
th { background: #0ABAB5; color: white; }
.back-btn {
  display: inline-block; margin-top: 20px; background: #007bff; color: white;
  padding: 10px 20px; border-radius: 6px; text-decoration: none;
}
.back-btn:hover { background: #0056b3; }
</style>
</head>
<body>

<h1>🧾 Chi tiết đơn hàng #<?php echo $order['id']; ?></h1>

<p><strong>Ngày đặt:</strong> <?php echo $order['order_date']; ?></p>
<p><strong>Trạng thái:</strong> <?php echo $order['status']; ?></p>
<p><strong>Địa chỉ giao hàng:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
<p><strong>SĐT:</strong> <?php echo htmlspecialchars($order['phone']); ?></p>
<p><strong>Tổng tiền:</strong> <?php echo number_format($totalAmount, 0, ',', '.'); ?> VND</p>

<h2>📦 Sản phẩm trong đơn</h2>

<table class="table">
  <tr>
    <th>Tên sản phẩm</th>
    <th>Giá</th>
    <th>Số lượng</th>
    <th>Thành tiền</th>
  </tr>
  <?php foreach ($items as $item): ?>
  <tr>
    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
    <td><?php echo number_format($item['price'], 0, ',', '.'); ?> VND</td>
    <td><?php echo $item['qty']; ?></td>
    <td><?php echo number_format($item['price'] * $item['qty'], 0, ',', '.'); ?> VND</td>
  </tr>
  <?php endforeach; ?>
</table>

<a href="admin_orders.php" class="back-btn">← Quay lại danh sách đơn hàng</a>

</body>
</html>

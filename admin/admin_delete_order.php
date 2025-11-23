<?php
session_start();
require_once '../php/config.php';


// Kiểm tra ID đơn hàng
if (!isset($_GET['id'])) {
    header("Location: admin_orders.php?error=Thiếu ID đơn hàng");
    exit;
}

$order_id = (int)$_GET['id'];

// Xóa dữ liệu chi tiết trước
$stmt1 = $pdo->prepare("DELETE FROM orther_items WHERE order_id = ?");
$stmt1->execute([$order_id]);

// Xóa đơn hàng chính
$stmt2 = $pdo->prepare("DELETE FROM orthers WHERE id = ?");
$stmt2->execute([$order_id]);

// Quay lại danh sách
header("Location: admin_orders.php?message=Đã xóa đơn hàng #$order_id thành công");
exit;
?>

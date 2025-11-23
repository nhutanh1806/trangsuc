<?php
session_start();
require_once 'config.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php?error=" . urlencode("Vui lòng đăng nhập để đặt hàng."));
    exit;
}

// Kiểm tra giỏ hàng
if (empty($_SESSION['cart'])) {
    header("Location: ../cart.php?error=" . urlencode("Giỏ hàng của bạn đang trống."));
    exit;
}

$user_id = $_SESSION['user_id'];
$fullname = $_POST['fullname'] ?? '';
$address  = $_POST['address'] ?? '';
$email    = $_POST['email'] ?? '';
$phone    = $_POST['phone'] ?? '';
$payment_method = $_POST['payment_method'] ?? 'cod';

$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['qty'];
}

// 1️⃣ Lưu vào bảng orthers
$stmt = $pdo->prepare("
    INSERT INTO orthers (user_id, order_date, total, status, address, phone, note)
    VALUES (?, NOW(), ?, 'pending', ?, ?, ?)
");
$stmt->execute([$user_id, $total, $address, $phone, "Thanh toán: $payment_method"]);

$order_id = $pdo->lastInsertId(); // lấy ID đơn hàng vừa tạo

// 2️⃣ Lưu từng sản phẩm vào bảng orther_items
$stmtItem = $pdo->prepare("
    INSERT INTO orther_items (order_id, product_id, quantity, price)
    VALUES (?, ?, ?, ?)
");

foreach ($_SESSION['cart'] as $item) {
    $stmtItem->execute([$order_id, $item['id'], $item['qty'], $item['price']]);
}

// 3️⃣ Xóa giỏ hàng
unset($_SESSION['cart']);

// 4️⃣ Chuyển sang trang cảm ơn
header("Location: ../thankyou.php?message=" . urlencode("Đặt hàng thành công!"));
exit;
?>

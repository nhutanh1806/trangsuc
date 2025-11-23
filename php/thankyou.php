<?php
session_start();
require_once 'config.php';

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($cart)) {
        echo "Giỏ hàng trống"; 
        exit;
    }

    // Lấy thông tin từ form thanh toán
    $fullname = $_POST['fullname'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $payment_method = $_POST['payment_method'];

    // Tính tổng
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['qty'];
    }

    try {
        // Bắt đầu giao dịch
        $pdo->beginTransaction();

        // 1️⃣ Thêm đơn hàng vào bảng orthers
        $stmt = $pdo->prepare("INSERT INTO orthers (user_id, address, phone, total, status, order_date, note)
                               VALUES (?, ?, ?, ?, 'pending', NOW(), ?)");
        $user_id = $_SESSION['user_id'] ?? 0;
        $note = "Thanh toán qua $payment_method - Email: $email - Họ tên: $fullname";

        $stmt->execute([$user_id, $address, $phone, $total, $note]);
        $order_id = $pdo->lastInsertId(); // Lấy id đơn hàng vừa thêm

        // 2️⃣ Thêm từng sản phẩm vào bảng orther_items
        $stmt_item = $pdo->prepare("INSERT INTO orther_items (order_id, product_id, quantity, price)
                                    VALUES (?, ?, ?, ?)");
        foreach ($cart as $id => $item) {
            $stmt_item->execute([$order_id, $id, $item['qty'], $item['price']]);
        }

        // Hoàn tất
        $pdo->commit();

        // Lưu tạm thông tin hiển thị ra màn hình cảm ơn
        $_SESSION['checkout_data'] = [
            'order_id' => $order_id,
            'fullname' => $fullname,
            'total' => $total,
            'order_time' => date('d/m/Y H:i'),
            'items' => $cart
        ];

        // Xóa giỏ hàng
        unset($_SESSION['cart']);

        // Chuyển hướng sang trang cảm ơn
        header("Location: thankyou.php");
        exit;

    } catch (Exception $e) {
        $pdo->rollBack();
        die("Lỗi khi lưu đơn hàng: " . $e->getMessage());
    }
}

if (!isset($_SESSION['checkout_data'])) {
    header("Location: thanhtoan.php");
    exit;
}

$checkout = $_SESSION['checkout_data'];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Đặt hàng thành công | Tiffany & Co</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&family=Open+Sans&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../css/thanhtoan.css">
</head>
<body>

<header class="checkout-header">
  <div class="container">
    <a href="index.php" class="brand">TIFFANY & CO</a>
    <nav>
      <a href="../index.php">Cửa hàng</a>
      <a href="cart.php">Giỏ hàng</a>
    </nav>
  </div>
</header>

<main class="container">
  <div class="thankyou-box">
    <h1>🎉 Cảm ơn bạn đã đặt hàng!</h1>
    <p>Mã đơn hàng: <strong>#<?php echo $checkout['order_id']; ?></strong></p>
    <p>Khách hàng: <strong><?php echo htmlspecialchars($checkout['fullname']); ?></strong></p>
    <p>Thời gian đặt: <strong><?php echo $checkout['order_time']; ?></strong></p>
    <p>Tổng cộng: <strong><?php echo number_format($checkout['total'], 0, ',', '.'); ?> VND</strong></p>

    <ul class="order-items">
      <?php foreach($checkout['items'] as $item): ?>
        <li>
          <span><?php echo htmlspecialchars($item['name']); ?></span>
          <span>SL: <?php echo $item['qty']; ?> × <?php echo number_format($item['price'],0,',','.'); ?> VND</span>
        </li>
      <?php endforeach; ?>
    </ul>

    <a href="../php/sanpham.php" class="btn">Tiếp tục mua sắm</a>
  </div>
</main>

<footer class="checkout-footer">
  <div class="container">
    <p>&copy; <?php echo date('Y'); ?> Tiffany & Co — Sự tinh tế vượt thời gian.</p>
  </div>
</footer>

</body>
</html>

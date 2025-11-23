<?php
session_start();
require_once 'config.php';

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total = 0;

// Tính tổng
foreach ($cart as $item) {
    $total += $item['price'] * $item['qty'];
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Thanh toán | Tiffany & Co</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&family=Open+Sans&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../css/thanhtoan.css">
</head>
<body>

<header class="checkout-header">
  <div class="container">
    <a href="index.php" class="brand">TIFFANY & CO</a>
  </div>
</header>

<main class="container">
<h1 class="page-title">Thanh toán đơn hàng</h1>

<?php if(empty($cart)): ?>
    <p>Giỏ hàng trống. <a href="sanpham.php">Quay lại cửa hàng</a></p>
<?php else: ?>
<section class="checkout-content">
    <div class="order-summary">
      <h2>Đơn hàng của bạn</h2>
      <ul>
        <?php foreach ($cart as $item): ?>
          <li>
            <img src="<?php echo '../' . htmlspecialchars($item['image']); ?>" alt="">
            <div>
              <strong><?php echo htmlspecialchars($item['name']); ?></strong><br>
              SL: <?php echo $item['qty']; ?> × <?php echo number_format($item['price'], 0, ',', '.'); ?> VND
            </div>
            <span><?php echo number_format($item['price'] * $item['qty'], 0, ',', '.'); ?> VND</span>
          </li>
        <?php endforeach; ?>
      </ul>
      <div class="total">
        <span>Tổng cộng:</span>
        <strong><?php echo number_format($total, 0, ',', '.'); ?> VND</strong>
      </div>
    </div>

    <div class="payment-form">
      <h2>Thông tin thanh toán</h2>
      <form action="thankyou.php" method="post">
        <label>Họ và tên</label>
        <input type="text" name="fullname" required>

        <label>Địa chỉ giao hàng</label>
        <input type="text" name="address" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Số điện thoại</label>
        <input type="tel" name="phone" required>

        <label>Phương thức thanh toán</label>
        <select name="payment_method" required>
          <option value="cod">Thanh toán khi nhận hàng (COD)</option>
          <option value="credit">Thẻ tín dụng / Ghi nợ</option>
          <option value="bank">Chuyển khoản ngân hàng</option>
        </select>

        <button type="submit" class="btn-primary">Hoàn tất đơn hàng</button>
      </form>
      <a href="cart.php" class="btn-back">← Quay lại giỏ hàng</a>
    </div>
</section>
<?php endif; ?>
</main>

<footer class="checkout-footer">
  <div class="container">
    <p>&copy; <?php echo date('Y'); ?> Tiffany & Co — Sự tinh tế vượt thời gian.</p>
  </div>
</footer>

</body>
</html>

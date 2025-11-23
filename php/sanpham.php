<?php
session_start();

// =====================
// KIỂM TRA ĐĂNG NHẬP
// =====================
if (!isset($_SESSION['username'])) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header('Location: login.php');
    exit;
}

// =====================
// KẾT NỐI CSDL
// =====================
require_once __DIR__ . '/config.php'; // Lưu ý có thêm / để tránh lỗi

// =====================
// LẤY DANH SÁCH SẢN PHẨM
// =====================
$products = [];
try {
    $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p style='color:red;'>Lỗi CSDL: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bộ sưu tập - Tiffany & Co</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Jura:wght@500&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Jura', sans-serif;
      background-color: #fafafa;
      color: #333;
      margin: 0;
      padding: 0;
    }

    /* HEADER */
    header {
      background-color: white;
      border-bottom: 1px solid #e0e0e0;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      position: sticky;
      top: 0;
      z-index: 100;
    }
    .container {
      max-width: 1200px;
      margin: auto;
      padding: 15px 25px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .brand {
      font-family: 'Playfair Display', serif;
      font-size: 26px;
      text-decoration: none;
      color: #009B9A;
      letter-spacing: 2px;
    }
    nav a {
      margin-left: 25px;
      text-decoration: none;
      color: #333;
      font-weight: 500;
      transition: 0.3s;
    }
    nav a:hover {
      color: #009B9A;
    }
    #cart-count {
      background: #009B9A;
      color: white;
      border-radius: 50%;
      padding: 2px 7px;
      font-size: 13px;
      margin-left: 4px;
    }

    /* MAIN */
    .page-title {
      text-align: center;
      font-size: 32px;
      font-family: 'Playfair Display', serif;
      color: #009B9A;
      margin: 60px 0 30px;
    }

    .product-list {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 35px;
      padding: 0 40px 80px;
    }

    .product-item {
      background: white;
      border-radius: 18px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.06);
      overflow: hidden;
      text-align: center;
      padding-bottom: 25px;
      transition: all 0.4s ease;
    }
    .product-item:hover {
      transform: translateY(-6px);
      box-shadow: 0 6px 30px rgba(0,0,0,0.1);
    }

    .product-item img {
      width: 100%;
      height: 240px;
      object-fit: cover;
      border-bottom: 1px solid #eee;
    }

    .product-item h2 {
      font-size: 18px;
      margin: 18px 0 6px;
      color: #333;
    }

    .price {
      color: #009B9A;
      font-weight: 600;
      margin-bottom: 8px;
      font-size: 17px;
    }

    .product-item p {
      font-size: 15px;
      color: #666;
      margin: 8px 15px 20px;
      min-height: 50px;
    }

    .add-cart-form {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 8px;
    }
    .add-cart-form input[type=number] {
      width: 60px;
      text-align: center;
      padding: 5px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    .btn {
      background: #009B9A;
      color: white;
      border: none;
      border-radius: 25px;
      padding: 10px 20px;
      cursor: pointer;
      font-size: 15px;
      transition: 0.3s;
    }
    .btn:hover {
      background: #007f7f;
    }

    /* FOOTER */
    footer {
      background: #009B9A;
      color: white;
      text-align: center;
      padding: 25px;
      margin-top: 60px;
      font-size: 14px;
      letter-spacing: 0.5px;
    }

    .quantity-control {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 4px;
}

.qty-btn {
  background: #e0f7f7;
  border: 1px solid #009B9A;
  color: #009B9A;
  font-weight: bold;
  width: 26px;
  height: 26px;
  border-radius: 6px;
  cursor: pointer;
  transition: 0.2s;
}

.qty-btn:hover {
  background: #009B9A;
  color: white;
}

.quantity-control input {
  width: 35px;       /* 👈 nhỏ gọn hơn */
  text-align: center;
  border: 1px solid #ccc;
  border-radius: 6px;
  height: 26px;
  font-size: 14px;
  background: #fff;
}

/* Tablet (768px - 1024px) */
@media screen and (max-width: 1024px) {
  .container {
    padding: 15px 20px;
  }
  
  .brand {
    font-size: 22px;
  }
  
  nav a {
    margin-left: 18px;
    font-size: 14px;
  }
  
  .page-title {
    font-size: 28px;
    margin: 50px 0 25px;
  }
  
  .product-list {
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
    padding: 0 25px 60px;
  }
  
  .product-item img {
    height: 200px;
  }
  
  .product-item h2 {
    font-size: 16px;
  }
  
  .price {
    font-size: 15px;
  }
  
  .product-item p {
    font-size: 14px;
    margin: 8px 12px 15px;
  }
}

/* Mobile (dưới 768px) */
@media screen and (max-width: 768px) {
  /* Header */
  header {
    position: sticky;
    top: 0;
  }
  
  .container {
    flex-direction: column;
    gap: 12px;
    padding: 12px 15px;
  }
  
  .brand {
    font-size: 20px;
    text-align: center;
  }
  
  nav {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 8px;
  }
  
  nav a {
    margin-left: 0;
    margin: 0 10px;
    font-size: 13px;
  }
  
  #cart-count {
    padding: 2px 6px;
    font-size: 12px;
  }
  
  /* Page Title */
  .page-title {
    font-size: 24px;
    margin: 40px 15px 20px;
  }
  
  /* Product List */
  .product-list {
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
    padding: 0 15px 50px;
  }
  
  .product-item {
    border-radius: 14px;
    padding-bottom: 20px;
  }
  
  .product-item img {
    height: 160px;
  }
  
  .product-item h2 {
    font-size: 14px;
    margin: 12px 0 5px;
  }
  
  .price {
    font-size: 14px;
    margin-bottom: 6px;
  }
  
  .product-item p {
    font-size: 12px;
    margin: 6px 10px 15px;
    min-height: 40px;
  }
  
  /* Quantity Control */
  .quantity-control {
    gap: 3px;
  }
  
  .qty-btn {
    width: 24px;
    height: 24px;
    font-size: 14px;
  }
  
  .quantity-control input {
    width: 32px;
    height: 24px;
    font-size: 13px;
  }
  
  /* Button */
  .btn {
    padding: 8px 16px;
    font-size: 13px;
    border-radius: 20px;
  }
  
  /* Footer */
  footer {
    padding: 20px 15px;
    margin-top: 40px;
    font-size: 12px;
  }
}

/* Mobile nhỏ (dưới 480px) */
@media screen and (max-width: 480px) {
  .container {
    padding: 10px 12px;
    gap: 10px;
  }
  
  .brand {
    font-size: 18px;
    letter-spacing: 1px;
  }
  
  nav a {
    font-size: 12px;
    margin: 0 8px;
  }
  
  #cart-count {
    padding: 1px 5px;
    font-size: 11px;
  }
  
  .page-title {
    font-size: 20px;
    margin: 30px 10px 15px;
  }
  
  /* Product List - 1 cột */
  .product-list {
    grid-template-columns: 1fr;
    gap: 20px;
    padding: 0 12px 40px;
  }
  
  .product-item {
    border-radius: 12px;
    padding-bottom: 18px;
  }
  
  .product-item img {
    height: 200px;
  }
  
  .product-item h2 {
    font-size: 16px;
    margin: 14px 0 6px;
  }
  
  .price {
    font-size: 15px;
  }
  
  .product-item p {
    font-size: 13px;
    margin: 8px 15px 18px;
    min-height: auto;
  }
  
  /* Quantity Control */
  .quantity-control {
    gap: 5px;
  }
  
  .qty-btn {
    width: 28px;
    height: 28px;
    font-size: 16px;
  }
  
  .quantity-control input {
    width: 38px;
    height: 28px;
    font-size: 14px;
  }
  
  .add-cart-form {
    gap: 10px;
  }
  
  .btn {
    padding: 10px 22px;
    font-size: 14px;
  }
  
  footer {
    padding: 18px 12px;
    font-size: 11px;
  }
}

/* Fix cho touch devices */
@media (hover: none) {
  .product-item:active {
    transform: translateY(-3px);
  }
  
  .btn:active {
    background: #007f7f;
  }
  
  .qty-btn:active {
    background: #009B9A;
    color: white;
  }
  
  nav a:active {
    color: #009B9A;
  }
}

/* Đảm bảo hình ảnh responsive */
img {
  max-width: 100%;
  height: auto;
}

/* Fix input trên iOS */
input[type="text"],
input[type="number"] {
  -webkit-appearance: none;
  -moz-appearance: textfield;
  font-size: 16px; /* Ngăn zoom trên iOS */
}

  </style>
</head>
<body>
<header>
  <div class="container">
    <a href="../index.php" class="brand">TIFFANY & CO</a>
    <nav>
      <a href="../index.php">Trang chủ</a>
      <a href="cart.php">
        Giỏ hàng 
        <span id="cart-count">
          <?php echo isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'qty')) : 0; ?>
        </span>
      </a>
    </nav>
  </div>
</header>

<main>
  <h1 class="page-title">Bộ sưu tập sản phẩm</h1>

  <?php if (!empty($products)): ?>
    <div class="product-list">
      <?php foreach ($products as $product): ?>
        <div class="product-item">
          <img src="<?php
  $imgPath = $product['image'];
  // Nếu ảnh chưa có ../ ở đầu, thêm vào
  if (strpos($imgPath, 'image/') === 0) {
      $imgPath = '../' . $imgPath;
  }
  echo htmlspecialchars($imgPath);
?>" alt="<?php echo htmlspecialchars($product['name']); ?>">


          <h2><?php echo htmlspecialchars($product['name']); ?></h2>
          <p class="price"><?php echo number_format($product['price'], 0, ',', '.'); ?> ₫</p>
          <p><?php echo htmlspecialchars($product['description']); ?></p>

          <form method="post" action="cart.php" class="add-cart-form">
            <input type="hidden" name="action" value="add">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            <div class="quantity-control">
  <button type="button" class="qty-btn minus">−</button>
  <input type="text" name="qty" value="0" readonly>
  <button type="button" class="qty-btn plus">+</button>
</div>

            <button class="btn">Thêm vào giỏ</button>
          </form>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p style="text-align:center; margin:40px;">Hiện chưa có sản phẩm nào trong cửa hàng.</p>
  <?php endif; ?>
</main>

<footer>
  <p>© <?php echo date('Y'); ?> Tiffany & Co. | Crafted with elegance</p>
</footer>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const forms = document.querySelectorAll('.add-cart-form');
  const cartCount = document.getElementById('cart-count');

  // --- Xử lý thêm giỏ hàng AJAX ---
  forms.forEach(form => {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const formData = new FormData(form);

      const response = await fetch('cart.php', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      });

      const data = await response.json().catch(() => null);
      if (data && data.cart_count !== undefined) {
        cartCount.textContent = data.cart_count;
        cartCount.style.transform = 'scale(1.3)';
        setTimeout(() => cartCount.style.transform = 'scale(1)', 300);
      }

      const btn = form.querySelector('.btn');
      btn.textContent = '✓ Đã thêm';
      btn.style.background = '#6bc8bf';
      setTimeout(() => {
        btn.textContent = 'Thêm vào giỏ';
        btn.style.background = '#009B9A';
      }, 1200);
    });
  });

  // --- Bộ đếm + / - với giới hạn 0 - 100 và hiệu ứng ---
  document.querySelectorAll('.quantity-control').forEach(qtyCtrl => {
    const input = qtyCtrl.querySelector('input');
    const plus = qtyCtrl.querySelector('.plus');
    const minus = qtyCtrl.querySelector('.minus');

    // Nếu chưa có giá trị thì bắt đầu từ 0
    if (!input.value) input.value = 0;

    plus.addEventListener('click', () => {
      let val = parseInt(input.value) || 0;
      if (val < 100) input.value = val + 1;
      animateButton(plus);
    });

    minus.addEventListener('click', () => {
      let val = parseInt(input.value) || 0;
      if (val > 0) input.value = val - 1;
      animateButton(minus);
    });

    // Hiệu ứng nhún & sáng Tiffany khi bấm
    function animateButton(btn) {
      btn.style.transform = 'scale(1.2)';
      btn.style.boxShadow = '0 0 8px rgba(0,155,154,0.6)';
      setTimeout(() => {
        btn.style.transform = 'scale(1)';
        btn.style.boxShadow = 'none';
      }, 200);
    }
  });
});
</script>
</body>
</html>

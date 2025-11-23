<?php
error_reporting(0);
session_start();
require_once 'config.php';

// === XÓA TOÀN BỘ GIỎ HÀNG ===
if (isset($_GET['action']) && $_GET['action'] === 'clear') {
    unset($_SESSION['cart']);
    header('Location: cart.php');
    exit;
}

// === AJAX thêm sản phẩm vào giỏ ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $product_id = (int)$_POST['product_id'];
    $qty = max(1, (int)($_POST['qty'] ?? 1));

    $stmt = $pdo->prepare("SELECT id, name, price, image FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();

    if ($product) {
        // Đảm bảo giá là số nguyên
        $cleanPrice = (int)$product['price'];

        if (!isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] = [
                'name'  => $product['name'],
                'price' => $cleanPrice,
                'image' => $product['image'],
                'qty'   => $qty
            ];
        } else {
            $_SESSION['cart'][$product_id]['qty'] += $qty;
        }

        header('Content-Type: application/json');
        echo json_encode([
            'success'     => true,
            'cart_count'  => array_sum(array_column($_SESSION['cart'], 'qty'))
        ]);
        exit;
    }
}

// === AJAX cập nhật số lượng ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_qty') {
    $product_id = (int)$_POST['product_id'];
    $qty = max(0, (int)$_POST['qty']);

    if (isset($_SESSION['cart'][$product_id])) {
        if ($qty > 0) {
            $_SESSION['cart'][$product_id]['qty'] = $qty;
        } else {
            unset($_SESSION['cart'][$product_id]);
        }
    }

    $total = 0;
    foreach ($_SESSION['cart'] ?? [] as $item) {
        $price = (int)$item['price'];
        $total += $item['qty'] * $price;
    }

    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'cart_count' => array_sum(array_column($_SESSION['cart'] ?? [], 'qty')),
        'total' => $total
    ]);
    exit;
}

// === Lấy sản phẩm trong giỏ ===
$cart_items = [];
$total = 0;
if (!empty($_SESSION['cart'])) {
    $ids = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("SELECT id, name, price, image FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $rows = $stmt->fetchAll();
    foreach ($rows as $r) {
        $pid = $r['id'];
        $price = (int)$r['price'];
        $qty = (int)($_SESSION['cart'][$pid]['qty'] ?? 0);
        $sub = $qty * $price;
        $total += $sub;
        $cart_items[] = [
            'id' => $pid,
            'name' => $r['name'],
            'price' => $price,
            'image' => $r['image'],
            'qty' => $qty,
            'sub' => $sub
        ];
    }
}
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Giỏ Hàng - Tiffany & Co</title>
  <link rel="stylesheet" href="../css/cart.css">
</head>
<body>
  <header class="site-header">
    <div class="container">
      <a href="../index.php" class="brand">TIFFANY & CO</a>
      <nav>
        <a href="sanpham.php">Cửa hàng</a>
        <a href="cart.php">Giỏ hàng 
          <span id="cart-count">
            <?php echo isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'qty')) : 0; ?>
          </span>
        </a>
      </nav>
    </div>
  </header>

  <main class="container">
    <h2>Giỏ hàng của bạn</h2>

    <?php if (empty($cart_items)): ?>
      <p>Giỏ hàng trống. <a href="sanpham.php">Tiếp tục mua sắm</a></p>
    <?php else: ?>
      <form method="post" action="cart.php?action=update">
        <table class="cart-table">
          <thead>
            <tr><th>Sản phẩm</th><th>Đơn giá</th><th>Số lượng</th><th>Thành tiền</th></tr>
          </thead>
          <tbody>
            <?php foreach ($cart_items as $item): ?>
              <tr data-id="<?php echo $item['id']; ?>">
                <td class="prod">
                  <img src="../<?php echo htmlspecialchars($item['image']); ?>" alt="" class="thumb">
                  <div><?php echo htmlspecialchars($item['name']); ?></div>
                </td>
                <td><?php echo number_format((int)$item['price'], 0, ',', '.'); ?> VND</td>
                <td>
                  <div class="qty-group">
                    <button type="button" class="btn-mini minus">-</button>
                    <input type="number" name="qty[<?php echo $item['id']; ?>]" value="<?php echo $item['qty']; ?>" min="0">
                    <button type="button" class="btn-mini plus">+</button>
                  </div>
                </td>
                <td>
                  <?php echo number_format((int)$item['sub'], 0, ',', '.'); ?> VND
                  <button type="button" class="btn-mini delete">🗑️</button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

        <div class="cart-actions">
          <a class="btn ghost" href="cart.php?action=clear">Xóa giỏ hàng</a>
        </div>
      </form>

      <div class="cart-summary">
        <h3>Tổng: <?php echo number_format((int)$total, 0, ',', '.'); ?> VND</h3>
        <button class="btn" type="button" onclick="window.location.href='thanhtoan.php'">Thanh toán</button>
      </div>
    <?php endif; ?>
  </main>

  <footer class="site-footer">
    <div class="container">
      <p>&copy; <?php echo date('Y'); ?> Luxury Jewelry </p>
    </div>
  </footer>

  <div id="toast" class="toast"></div>

  <script>
document.addEventListener('DOMContentLoaded', () => {
  const cartCount = document.getElementById('cart-count');
  const toast = document.getElementById('toast');

  function showToast(message) {
    toast.textContent = message;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 2000);
  }

  document.querySelector('.cart-table')?.addEventListener('click', async (e) => {
    const btn = e.target.closest('.btn-mini');
    if (!btn) return;

    const row = btn.closest('tr');
    const pid = row.dataset.id;
    const input = row.querySelector('input[type="number"]');
    let qty = parseInt(input.value) || 0;

    if (btn.classList.contains('plus')) qty++;
    else if (btn.classList.contains('minus')) qty = Math.max(0, qty - 1);
    else if (btn.classList.contains('delete')) qty = 0;

    const fd = new FormData();
    fd.append('action', 'update_qty');
    fd.append('product_id', pid);
    fd.append('qty', qty);

    const res = await fetch('cart.php', { method: 'POST', body: fd });
    const data = await res.json().catch(() => null);

    if (data?.success) {
      input.value = qty;

      if (qty === 0) row.remove();
      else {
        const priceText = row.querySelector('td:nth-child(2)').textContent.replace(/[^\d]/g, '');
        const price = parseInt(priceText);
        const sub = qty * price;
        row.querySelector('td:nth-child(4)').childNodes[0].nodeValue =
          new Intl.NumberFormat('vi-VN').format(sub) + ' VND';
      }

      cartCount.textContent = data.cart_count;
      document.querySelector('.cart-summary h3').textContent =
        'Tổng: ' + new Intl.NumberFormat('vi-VN').format(data.total) + ' VND';

      cartCount.style.transform = 'scale(1.6)';
      cartCount.style.transition = 'transform 0.25s ease';
      setTimeout(() => { cartCount.style.transform = 'scale(1)'; }, 150);

      showToast(qty === 0 ? '🗑️ Đã xóa sản phẩm' : '✅ Cập nhật thành công');
    }
  });
});
</script>
</body>
</html>

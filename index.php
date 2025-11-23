  <?php
session_start();
  require_once __DIR__ . '/php/config.php';



  // Lấy sản phẩm từ database
  $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC LIMIT 4");
  $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Danh sách card tĩnh
  $cards = [
    ['img'=>'image/T.jpg','title'=>'Tiffany T','link'=>'#'],
    ['img'=>'image/hard.jpg','title'=>'HardWear','link'=>'#'],
    ['img'=>'image/knot.jpg','title'=>'Knot','link'=>'#'],
    ['img'=>'image/lock.jpg','title'=>'Lock','link'=>'#'],
  ];

  // Hàm định dạng tiền Việt
  function format_vnd($num) {
      return number_format($num, 0, ',', '.') . ' ₫';
  }
  ?>
  <!DOCTYPE html>
  <html lang="vi">
  <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TIFFANY & CO</title>
  <link rel="stylesheet" href="css/style.css">
  </head>
  <body>

  <header>
    <div class="container header-content">
      <h1 class="logo" onclick="window.location.href='index.php'" style="cursor:pointer;">TIFFANY <span>& CO</span></h1>
      <nav>
        <a href="index.php">Trang chủ</a>
        <a href="php/gioithieu.php">Giới thiệu</a>
        <a href="php/sanpham.php">Sản phẩm</a>
        <a href="php/datlich.php">Đặt Lịch</a>

        <?php if (!empty($_SESSION['username'])): ?>
    <span style="margin-left:20px;">Xin chào, <?= htmlspecialchars($_SESSION['username']) ?>!</span>
    <a href="/trangsuc/php/login.php?action=logout" style="color:red; margin-left:10px;">Đăng xuất</a>
  <?php else: ?>
    <a href="/trangsuc/php/login.php" style="margin-left:20px;">Đăng nhập</a>
  <?php endif; ?>

      </nav>
    </div>
  </header>

  <!-- HERO SECTION -->
  <section id="home" class="hero">
    <div class="container hero-content">
      <div class="hero-text">
        <h2>Tỏa sáng cùng trang sức của bạn</h2>
        <p>Tiffany & Co. là biểu tượng của sự tinh tế và sang trọng bậc nhất trong thế giới trang sức. Thành lập tại New York năm 1837, thương hiệu nổi tiếng với những thiết kế tinh xảo, chất liệu quý hiếm và sắc xanh biểu trưng đặc trưng.</p>
        <a href="gioithieu.php" class="btn">Xem ngay</a>
      </div>
    </div>
  </section>

  <!-- PRODUCTS -->
  <section id="products" class="container products">
    <h2>SẢN PHẨM MỚI</h2>
    <div class="grid">
      <?php foreach ($products as $p): ?>
        <div class="card"
            style="text-decoration:none; color:inherit; cursor:pointer;"
            onclick='openPopup(<?= json_encode([
                "id" => $p["id"],
                "name" => $p["name"],
                "price" => $p["price"],
                "description" => $p["description"] ?? "Không có mô tả.",
                "image" => $p["image"]
              ], JSON_UNESCAPED_UNICODE) ?>)'>
  <img src="<?= str_replace('../', '', htmlspecialchars($p['image'])) ?>" alt="<?= htmlspecialchars($p['name']) ?>">
          <div class="card-body">
            <h3><?= htmlspecialchars($p['name']) ?></h3>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- POPUP -->
  <div id="popup" class="popup" style="display:none;">
    <div class="popup-content">
      <span class="close" onclick="closePopup()">&times;</span>
      <img id="popup-img" src="" alt="">
      <h2 id="popup-name"></h2>
      <p id="popup-desc"></p>
      <p id="popup-price" style="font-weight:bold;"></p>
      <button class="btn" onclick="addToCart()">🛒 Thêm vào giỏ hàng</button>
    </div>
  </div>

  <!-- INTRO -->
  <section id="introduce" class="intro">
    <div class="two-images">
      <div class="left">
        <img src="image/bac.jpg" alt="Trang sức bạc">
        <p class="caption">Trang Sức Bạc</p>
      </div>
      <div class="right">
        <img src="image/vang.jpg" alt="Trang sức vàng">
        <p class="caption">Trang Sức Vàng</p>
      </div>
    </div>
  </section>

  <main class="main">
    <section class="grids">
      <?php foreach($cards as $c): ?>
        <article class="cards">
          <a class="card-medias" href="<?=htmlspecialchars($c['link'])?>">
            <img src="<?=htmlspecialchars($c['img'])?>" alt="<?=htmlspecialchars($c['title'])?>">
          </a>
          <div class="card-bodys">
            <h2 class="card-titles"><?=htmlspecialchars($c['title'])?></h2>
            <a class="shop-btns" href="php/sanpham.php">MUA NGAY</a>
          </div>
        </article>
      <?php endforeach; ?>
    </section>
  </main>

  <section class="super">
    <div class="hero-texts">
      <p class="categorys">LOVE & ENGAGEMENT</p>
      <h1>Biểu Tượng<br>Cuối Cùng Của<br>Tình Yêu</h1>
      <p class="description">
        Kể từ khi Charles Lewis Tiffany giới thiệu với thế giới về nhẫn đính hôn vào năm 1886, Tiffany & Co. đã trở thành trung tâm của những câu chuyện tình yêu vĩ đại nhất thế giới.
      </p>
      <a href=" php/datlich.php" class="cta">ĐẶT LỊCH HẸN</a>
    </div>
    <div class="hero-images">
    <img src="image/hon.jpg" alt="Tiffany 1837">

    </div>
  </section>

  <footer class="footer">
    <div class="footer-container">
      <div class="footer-left">
        <!-- Thêm thông tin liên hệ -->
        <p> Hotline: <a href="tel:+84123456789">+84 123 456 789</a></p>
        <p> Email: <a href="mailto:contact@tiffany.com">contact@tiffany.com</a></p>
        <p> Địa chỉ: 123 Tiffany Street, New York, USA</p>
      </div>
      <div class="footer-center">
        <h1 class="logo">T C</h1>
      </div>
      <div class="footer-right">
        <a href="https://www.instagram.com/tiffanyandco/">Instagram</a>
        <a href="https://x.com/TiffanyAndCo">Twitter</a>
        <a href="https://www.facebook.com/Tiffany/">Facebook</a>
        <a href="https://www.youtube.com/OfficialTiffanyAndCo">YouTube</a>

              <p>Change Location: <a href="#">United States</a></p>
        <p>T&amp;Co. 2025</p>
      </div>
    </div>
  </footer> 

  <script>
  let currentProduct = null;

  function openPopup(product) {
    currentProduct = product;
    document.getElementById("popup-img").src = "../" + product.image;
    document.getElementById("popup-name").textContent = product.name;
    document.getElementById("popup-desc").textContent = product.description || "Không có mô tả.";
    document.getElementById("popup-price").textContent =
      "Giá: " + new Intl.NumberFormat('vi-VN').format(product.price) + " ₫";
    document.getElementById("popup").style.display = "flex";
  }

  function closePopup() {
    document.getElementById("popup").style.display = "none";
  }

  // Gửi sản phẩm sang cart.php
  function addToCart() {
    if (!currentProduct) return;

    const fd = new FormData();
    fd.append('action', 'add');
    fd.append('product_id', currentProduct.id);
    fd.append('qty', 1);

    fetch('/trangsuc/php/cart.php', {
      method: 'POST',
      body: fd
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert("✅ Đã thêm vào giỏ hàng!");
        // Chuyển đúng đến file cart.php
        window.location.href = "/trangsuc/php/cart.php";
      } else {
        alert("❌ Thêm sản phẩm thất bại!");
        console.log(data);
      }
    })
    .catch(err => console.error("Fetch error:", err));
  }


  window.onclick = function(event) {
    const popup = document.getElementById("popup");
    if (event.target === popup) popup.style.display = "none";
  };
  </script>

  </body>
  </html>

<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Biểu Tượng Hộp Màu Xanh - Tiffany & Co</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    /* ===== RESET ===== */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Cormorant Garamond', serif;
      background-color: #fdfefe;
      color: #333;
      overflow-x: hidden;
      line-height: 1.7;
      position: relative;
      min-height: 100vh;
    }

    /* ===== HEART BACKGROUND ===== */
    .heart {
      position: fixed;
      top: -50px;
      width: 20px;
      height: 20px;
      background-color: #81D8D0;
      transform: rotate(45deg);
      opacity: 0.5;
      animation: fall linear forwards;
      z-index: 1;
      pointer-events: none;
    }
    .heart::before,
    .heart::after {
      content: "";
      position: absolute;
      width: 20px;
      height: 20px;
      background-color: #81D8D0;
      border-radius: 50%;
    }
    .heart::before {
      top: -10px;
      left: 0;
    }
    .heart::after {
      left: -10px;
      top: 0;
    }
    @keyframes fall {
      to {
        transform: translateY(110vh) rotate(720deg);
        opacity: 0;
      }
    }

    /* ===== HEADER ===== */
    header {
      background-color: #7FD4CC;
      padding: 20px 50px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: white;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      position: sticky;
      top: 0;
      z-index: 100;
    }
    .logo {
      font-size: 28px;
      font-weight: bold;
      letter-spacing: 1.5px;
    }
    nav a {
      color: white;
      text-decoration: none;
      margin: 0 15px;
      font-size: 16px;
      transition: 0.3s;
    }
    nav a:hover {
      text-decoration: underline;
      opacity: 0.9;
    }

    /* ===== HERO ===== */
    .hero {
      height: 85vh;
      background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)),
                  url('../image/hon.jpg') center/cover no-repeat;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: white;
      position: relative;
      z-index: 2;
    }
    .hero h1 {
      font-size: 54px;
      max-width: 900px;
      line-height: 1.3;
      text-shadow: 0 4px 10px rgba(0,0,0,0.5);
      animation: fadeIn 1.5s ease;
    }

    /* ===== SECTIONS ===== */
    section {
      padding: 80px 8%;
      text-align: center;
      position: relative;
      z-index: 2;
    }
    section h2 {
      color: #0A8F8A;
      font-size: 34px;
      margin-bottom: 20px;
      font-weight: 600;
    }
    section h2::after {
      content: '';
      width: 60px;
      height: 3px;
      background-color: #0A8F8A;
      display: block;
      margin: 15px auto;
      border-radius: 2px;
    }
    section p {
      max-width: 800px;
      margin: 0 auto;
      color: #555;
      font-size: 18px;
      line-height: 1.8;
    }

    /* ===== PRODUCT GRID ===== */
    .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 45px;
      margin-top: 60px;
    }
    .product-card {
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.08);
      overflow: hidden;
      transition: all 0.5s ease;
    }
    .product-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    }
    .product-card img {
      width: 100%;
      height: 260px;
      object-fit: cover;
    }
    .product-card h3 {
      color: #0A8F8A;
      margin: 20px 0 10px;
      font-size: 22px;
    }
    .product-card p {
      padding: 0 20px 25px;
      color: #666;
      font-size: 16px;
    }
    .btn {
      display: inline-block;
      background-color: #0A8F8A;
      color: white;
      padding: 10px 25px;
      border-radius: 30px;
      text-decoration: none;
      transition: 0.3s;
      margin-bottom: 20px;
    }
    .btn:hover {
      background-color: #087A76;
    }

    /* ===== PARALLAX BREAK ===== */
    .break {
      height: 55vh;
      background: linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)),
                  url('../image/n3.jpg') center/cover fixed no-repeat;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      text-align: center;
      font-size: 36px;
      font-weight: 500;
      text-shadow: 0 4px 12px rgba(0,0,0,0.5);
    }

    /* ===== FOOTER ===== */
    footer {
      background-color: #7FD4CC;
      color: white;
      text-align: center;
      padding: 40px 20px;
      font-size: 16px;
      margin-top: 50px;
      position: relative;
      z-index: 2;
    }
    footer a {
      color: white;
      text-decoration: none;
      margin: 0 10px;
    }
    footer a:hover {
      text-decoration: underline;
    }

    /* ===== FADE ANIMATION ===== */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(40px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .fade {
      opacity: 0;
      transform: translateY(40px);
      transition: all 1s ease;
    }
    .fade.show {
      opacity: 1;
      transform: translateY(0);
    }
    /* ============================================
   RESPONSIVE CSS - THÊM VÀO CUỐI THẺ <style>
   (Trước thẻ đóng </style>)
   ============================================ */

/* Tablet (768px - 1024px) */
@media screen and (max-width: 1024px) {
  header {
    padding: 15px 30px;
  }
  
  .logo {
    font-size: 24px;
  }
  
  nav a {
    margin: 0 10px;
    font-size: 14px;
  }
  
  .hero {
    height: 70vh;
  }
  
  .hero h1 {
    font-size: 42px;
    padding: 0 30px;
  }
  
  section {
    padding: 60px 5%;
  }
  
  section h2 {
    font-size: 28px;
  }
  
  section p {
    font-size: 16px;
  }
  
  .product-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
  }
  
  .break {
    height: 45vh;
    font-size: 28px;
    padding: 0 30px;
  }
}

/* Mobile (dưới 768px) */
@media screen and (max-width: 768px) {
  /* Header */
  header {
    flex-direction: column;
    padding: 15px 20px;
    gap: 15px;
  }
  
  .logo {
    font-size: 22px;
    text-align: center;
  }
  
  nav {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 5px;
  }
  
  nav a {
    margin: 5px 8px;
    font-size: 13px;
    padding: 5px 0;
  }
  
  /* Hero */
  .hero {
    height: 60vh;
    min-height: 350px;
  }
  
  .hero h1 {
    font-size: 28px;
    padding: 0 20px;
    line-height: 1.4;
  }
  
  /* Sections */
  section {
    padding: 50px 20px;
  }
  
  section h2 {
    font-size: 24px;
    margin-bottom: 15px;
  }
  
  section h2::after {
    width: 50px;
    height: 2px;
    margin: 12px auto;
  }
  
  section p {
    font-size: 15px;
    line-height: 1.7;
    padding: 0 10px;
  }
  
  /* Product Grid */
  .product-grid {
    grid-template-columns: 1fr;
    gap: 30px;
    margin-top: 40px;
  }
  
  .product-card {
    border-radius: 15px;
  }
  
  .product-card img {
    height: 220px;
  }
  
  .product-card h3 {
    font-size: 20px;
    margin: 15px 0 8px;
  }
  
  .product-card p {
    font-size: 14px;
    padding: 0 15px 20px;
  }
  
  .btn {
    padding: 10px 22px;
    font-size: 14px;
  }
  
  /* Parallax Break */
  .break {
    height: 40vh;
    min-height: 250px;
    font-size: 20px;
    padding: 30px 25px;
    line-height: 1.5;
    background-attachment: scroll; /* Fix cho mobile */
  }
  
  /* Footer */
  footer {
    padding: 30px 20px;
    font-size: 14px;
    margin-top: 30px;
  }
  
  footer a {
    margin: 0 8px;
    font-size: 13px;
  }
  
  footer div {
    margin-top: 15px;
  }
  
  /* Heart animation - nhỏ hơn trên mobile */
  .heart {
    width: 15px !important;
    height: 15px !important;
  }
  
  .heart::before,
  .heart::after {
    width: 15px;
    height: 15px;
  }
  
  .heart::before {
    top: -7.5px;
  }
  
  .heart::after {
    left: -7.5px;
  }
}

/* Mobile nhỏ (dưới 480px) */
@media screen and (max-width: 480px) {
  header {
    padding: 12px 15px;
    gap: 12px;
  }
  
  .logo {
    font-size: 20px;
  }
  
  nav a {
    font-size: 12px;
    margin: 4px 6px;
  }
  
  .hero {
    height: 55vh;
    min-height: 300px;
  }
  
  .hero h1 {
    font-size: 22px;
    padding: 0 15px;
  }
  
  section {
    padding: 40px 15px;
  }
  
  section h2 {
    font-size: 20px;
  }
  
  section p {
    font-size: 14px;
  }
  
  .product-card img {
    height: 200px;
  }
  
  .product-card h3 {
    font-size: 18px;
  }
  
  .product-card p {
    font-size: 13px;
  }
  
  .btn {
    padding: 9px 20px;
    font-size: 13px;
  }
  
  .break {
    height: 35vh;
    min-height: 200px;
    font-size: 17px;
    padding: 25px 20px;
  }
  
  footer {
    padding: 25px 15px;
    font-size: 13px;
  }
  
  footer a {
    font-size: 12px;
    margin: 0 5px;
  }
}

/* Fix cho touch devices */
@media (hover: none) {
  .product-card:active {
    transform: translateY(-5px);
  }
  
  .btn:active {
    background-color: #087A76;
  }
  
  nav a:active {
    opacity: 0.7;
  }
}

/* Đảm bảo hình ảnh responsive */
img {
  max-width: 100%;
  height: auto;
}
  </style>
</head>
<body>

<header>
  <div class="logo">TIFFANY <span>& CO</span></div>
  <nav>
    <a href="index.php">Trang chủ</a>
    <a href="gioithieu.php">Giới thiệu</a>
    <a href="sanpham.php">Sản phẩm</a>
    <a href="phucvuban.php">Phục vụ bạn</a>
    <a href="bieutuongxanh.php"><b>Biểu tượng hộp màu xanh</b></a>
  </nav>
</header>

<section class="hero">
  <h1>Biểu Tượng Hộp Màu Xanh – The Tiffany Blue Box</h1>
</section>

<section class="fade">
  <h2>Biểu Tượng Của Tình Yêu & Sự Tinh Tế</h2>
  <p>
    Màu xanh Tiffany Blue – sắc màu của cảm xúc, biểu tượng của tình yêu tinh tế từ năm 1845.  
    Mỗi chiếc hộp Tiffany Blue Box® được trao đi không chỉ chứa đựng trang sức,  
    mà còn là lời hứa về tình yêu vĩnh cửu và sự trân trọng sâu sắc.
  </p>
</section>

<section class="fade">
  <h2>Gợi Ý Cho Kế Hoạch Cầu Hôn Hoàn Hảo</h2>
  <div class="product-grid">
    <div class="product-card">
      <img src="../image/nhan_cauhon.jpg" alt="Nhẫn cầu hôn Tiffany">
      <h3>Nhẫn Đính Hôn Tiffany® Setting</h3>
      <p>Viên kim cương hoàn hảo, tượng trưng cho tình yêu bất diệt và lời hứa trọn đời.</p>
      <a href="sanpham.php" class="btn">Khám phá</a>
    </div>
    <div class="product-card">
      <img src="../image/hopqua.jpg" alt="Hộp quà Tiffany Blue Box">
      <h3>Tiffany Blue Box®</h3>
      <p>Chiếc hộp biểu tượng – khởi đầu cho những lời cầu hôn ngọt ngào nhất.</p>
      <a href="sanpham.php" class="btn">Mua ngay</a>
    </div>
    <div class="product-card">
      <img src="../image/daychuyen_tinhyeu.jpg" alt="Dây chuyền tình yêu Tiffany">
      <h3>Dây Chuyền Tình Yêu</h3>
      <p>Vẻ đẹp tinh khiết tôn vinh cảm xúc lãng mạn và chân thành.</p>
      <a href="sanpham.php" class="btn">Khám phá thêm</a>
    </div>
  </div>
</section>

<div class="break">
  “Mọi câu chuyện tình đều bắt đầu từ chiếc hộp màu xanh”
</div>

<section class="fade">
  <h2>Đặt Lịch Tư Vấn Riêng</h2>
  <p>
    Hãy để Tiffany & Co cùng bạn tạo nên khoảnh khắc cầu hôn hoàn hảo.  
    Đội ngũ chuyên viên của chúng tôi sẽ đồng hành, giúp bạn chọn nhẫn và hộp quà mang dấu ấn riêng.
  </p>
  <a href="datlichhen.php" class="btn">💍 Đặt lịch ngay</a>
</section>

<footer>
  <p>© 2025 Tiffany & Co. | The Tiffany Blue Box® – Biểu tượng của tình yêu</p>
  <div>
    <a href="https://www.instagram.com/tiffanyandco/">Instagram</a> |
    <a href="https://www.facebook.com/Tiffany/">Facebook</a> |
    <a href="https://www.youtube.com/OfficialTiffanyAndCo">YouTube</a>
  </div>
</footer>

<script>
  // Hiệu ứng trái tim rơi
  function createHeart() {
    const heart = document.createElement('div');
    heart.classList.add('heart');
    heart.style.left = Math.random() * 100 + 'vw';
    heart.style.animationDuration = Math.random() * 5 + 5 + 's';
    heart.style.width = heart.style.height = Math.random() * 15 + 10 + 'px';
    document.body.appendChild(heart);
    setTimeout(() => heart.remove(), 10000);
  }
  setInterval(createHeart, 400);

  // Hiệu ứng fade-in khi cuộn
  const fadeEls = document.querySelectorAll('.fade');
  window.addEventListener('scroll', () => {
    fadeEls.forEach(el => {
      const rect = el.getBoundingClientRect().top;
      if (rect < window.innerHeight - 100) el.classList.add('show');
    });
  });
</script>

</body>
</html>

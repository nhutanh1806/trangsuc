<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Phục Vụ Bạn - Tiffany & Co</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: 'Times New Roman', serif;
      background-color: #f7fdfd;
      color: #333;
      margin: 0;
      padding: 0;
    }
    header {
      background-color: #0ABAB5;
      color: white;
      padding: 20px;
      text-align: center;
    }
    header .logo {
      font-size: 28px;
      font-weight: bold;
      letter-spacing: 1px;
    }
    header nav {
      margin-top: 10px;
    }
    header nav a {
      color: white;
      text-decoration: none;
      margin: 0 15px;
      font-size: 17px;
      transition: 0.3s;
    }
    header nav a:hover {
      text-decoration: underline;
    }
    .hero {
      background-image: url('../image/phucvu.jpg');
      background-size: cover;
      background-position: center;
      height: 350px;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: white;
      position: relative;
    }
    .hero::after {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0,0,0,0.4);
    }
    .hero h1 {
      position: relative;
      font-size: 40px;
      z-index: 2;
    }
    .container {
      max-width: 1000px;
      margin: 60px auto;
      background: #fff;
      border-radius: 15px;
      padding: 40px 50px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    .container h2 {
      color: #0ABAB5;
      border-bottom: 2px solid #0ABAB5;
      display: inline-block;
      padding-bottom: 5px;
      margin-bottom: 20px;
    }
    .service {
      margin-bottom: 40px;
    }
    .service img {
      width: 100%;
      border-radius: 10px;
      margin-bottom: 15px;
    }
    .service h3 {
      color: #0ABAB5;
      margin-bottom: 10px;
    }
    .service p {
      line-height: 1.6;
    }
    footer {
      background-color: #0ABAB5;
      color: white;
      text-align: center;
      padding: 20px;
      margin-top: 50px;
    }
    footer a {
      color: white;
      margin: 0 10px;
      text-decoration: none;
    }
    footer a:hover {
      text-decoration: underline;
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
    <a href="lienhe.php">Liên hệ</a>
    <a href="vanchuyen.php">Vận chuyển & Trả hàng</a>
    <a href="phucvuban.php"><b>Phục vụ bạn</b></a>
  </nav>
</header>

<section class="hero">
  <h1>Phục Vụ Bạn Với Sự Tận Tâm Tuyệt Đối</h1>
</section>

<div class="container">
  <div class="service">
    <h2>Dịch Vụ Làm Sạch & Bảo Dưỡng Trang Sức</h2>
    <img src="../image/baoduong.jpg" alt="Bảo dưỡng trang sức">
    <p>
      Giữ cho món trang sức Tiffany của bạn luôn tỏa sáng. Chúng tôi cung cấp dịch vụ làm sạch, đánh bóng và bảo dưỡng miễn phí tại các cửa hàng Tiffany & Co trên toàn quốc.
    </p>
  </div>

  <div class="service">
    <h2>Tư Vấn Cá Nhân</h2>
    <img src="../image/tuvan.jpg" alt="Tư vấn khách hàng">
    <p>
      Đội ngũ chuyên viên của Tiffany luôn sẵn sàng giúp bạn tìm ra món trang sức hoàn hảo — từ nhẫn đính hôn đến quà tặng đặc biệt.  
      <br><a href="datlichhen.php" style="color:#0ABAB5; font-weight:bold;">→ Đặt lịch hẹn ngay</a>
    </p>
  </div>

  <div class="service">
    <h2>Chăm Sóc Sau Mua Hàng</h2>
    <img src="../image/chamsoc.jpg" alt="Chăm sóc khách hàng">
    <p>
      Chúng tôi đồng hành cùng bạn sau khi mua hàng. Từ đổi kích cỡ nhẫn đến khắc tên hoặc sửa chữa, Tiffany luôn đảm bảo sự hoàn hảo cho từng sản phẩm của bạn.
    </p>
  </div>

  <div class="service">
    <h2>Liên Hệ Đội Ngũ Hỗ Trợ</h2>
    <p>
      📞 Hotline: <strong>1900 123 456</strong><br>
      📧 Email: <strong>support@tiffany.com.vn</strong><br>
      ⏰ Giờ làm việc: 8:00 - 21:00 (Thứ 2 - Chủ nhật)
    </p>
  </div>
</div>

<footer>
  <p>© 2025 Tiffany & Co. | Sang trọng – Tinh tế – Tận tâm</p>
  <div>
    <a href="https://www.instagram.com/tiffanyandco/">Instagram</a> |
    <a href="https://www.facebook.com/Tiffany/">Facebook</a> |
    <a href="https://www.youtube.com/OfficialTiffanyAndCo">YouTube</a>
  </div>
</footer>

</body>
</html>

<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Vận chuyển & Trả hàng | Tiffany & Co.</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    :root {
      --tiffany: #81D8D0;
      --text: #222;
      --bg: #fafafa;
    }

    body {
      margin: 0;
      font-family: 'Georgia', serif;
      background-color: var(--bg);
      color: var(--text);
      line-height: 1.7;
    }

    /* HEADER */
    header {
      background-color: white;
      border-bottom: 1px solid #e5e5e5;
      padding: 18px 40px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 999;
    }

    header h1 {
      color: var(--tiffany);
      font-size: 24px;
      letter-spacing: 2px;
      margin: 0;
    }

    nav a {
      text-decoration: none;
      color: var(--text);
      margin: 0 15px;
      font-weight: 500;
      position: relative;
    }

    nav a::after {
      content: "";
      position: absolute;
      bottom: -3px;
      left: 0;
      width: 0%;
      height: 1.5px;
      background-color: var(--tiffany);
      transition: 0.3s;
    }

    nav a:hover::after {
      width: 100%;
    }

    /* HERO SECTION */
    .hero {
      background: url('../image/w6.jpg') center/cover no-repeat;
      height: 400px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      text-shadow: 0 3px 15px rgba(0,0,0,0.4);
    }

    .hero h2 {
      font-size: 48px;
      font-weight: 400;
      letter-spacing: 1px;
    }

    /* CONTENT */
    .container {
      max-width: 1100px;
      margin: 80px auto;
      padding: 0 20px;
    }

    .section {
      margin-bottom: 80px;
    }

    .section h3 {
      font-size: 28px;
      color: var(--tiffany);
      margin-bottom: 15px;
      border-bottom: 1px solid #e0e0e0;
      padding-bottom: 8px;
      display: inline-block;
    }

    .section p {
      margin-bottom: 15px;
      color: #444;
    }

    ul {
      margin-left: 25px;
    }

    li {
      margin-bottom: 8px;
    }

    /* HIGHLIGHT BOX */
    .note {
      background: #e8f9f9;
      border-left: 4px solid var(--tiffany);
      padding: 18px 22px;
      border-radius: 10px;
      margin-top: 20px;
      font-style: italic;
    }

    /* BACK BUTTON */
    .btn-back {
      display: inline-block;
      margin-top: 40px;
      background-color: var(--tiffany);
      color: white;
      text-decoration: none;
      padding: 12px 26px;
      border-radius: 8px;
      transition: 0.3s;
    }

    .btn-back:hover {
      background-color: #6ccdc6;
      transform: scale(1.05);
    }

    /* FOOTER */
    footer {
      background-color: white;
      border-top: 1px solid #e0e0e0;
      text-align: center;
      padding: 30px 0;
      color: #666;
      font-size: 15px;
    }

    footer a {
      color: var(--tiffany);
      text-decoration: none;
      margin: 0 10px;
    }

    footer a:hover {
      text-decoration: underline;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
      .hero h2 {
        font-size: 32px;
        text-align: center;
        padding: 0 10px;
      }
    }
  </style>
</head>
<body>

<header>
  <a href="index.php">TIFFANY & CO</a>
  <nav>
    <a href="index.php">Trang chủ</a>
    <a href="gioithieu.php">Giới thiệu</a>
    <a href="sanpham.php">Sản phẩm</a>
    <a href="datlich.php">Đặt lịch</a>
    <a href="vanchuyen.php" style="color:var(--tiffany);">Vận chuyển</a>
  </nav>
</header>

<section class="hero">
  <h2>Vận chuyển & Trả hàng</h2>
</section>

<div class="container">

  <div class="section">
    <h3>Chính sách vận chuyển</h3>
    <p>Tiffany & Co. tự hào mang đến dịch vụ giao hàng cao cấp, nhanh chóng và an toàn trên toàn quốc. Mỗi đơn hàng đều được đóng gói trong hộp Tiffany Blue Box – biểu tượng sang trọng và tinh tế của thương hiệu.</p>
    <ul>
      <li>⏱ Thời gian giao hàng: 2–5 ngày làm việc tùy khu vực.</li>
      <li>📦 Đơn hàng được gói cẩn thận, đảm bảo an toàn tuyệt đối khi vận chuyển.</li>
      <li>✉️ Mã vận đơn được gửi qua email để bạn dễ dàng theo dõi.</li>
    </ul>
  </div>

  <div class="section">
    <h3>Trả hàng & hoàn tiền</h3>
    <p>Nếu bạn không hoàn toàn hài lòng với sản phẩm, Tiffany & Co. chấp nhận đổi hoặc trả trong vòng <strong>7 ngày</strong> kể từ ngày nhận hàng.</p>
    <ul>
      <li>Sản phẩm phải còn nguyên vẹn, chưa qua sử dụng hoặc chỉnh sửa.</li>
      <li>Cần có hóa đơn hoặc email xác nhận đơn hàng.</li>
      <li>Chúng tôi hỗ trợ 100% chi phí vận chuyển khi trả hàng.</li>
    </ul>
    <div class="note">
      ⚠️ Lưu ý: Các sản phẩm khắc chữ, đặt riêng hoặc trong chương trình khuyến mãi sẽ không áp dụng đổi/trả.
    </div>
  </div>

  <div class="section">
    <h3>Hỗ trợ khách hàng</h3>
    <p>Đội ngũ Tiffany & Co. luôn sẵn sàng hỗ trợ bạn qua các kênh sau:</p>
    <ul>
      <li>📧 Email: <a href="mailto:support@tiffanyco.vn">support@tiffanyco.vn</a></li>
      <li>📞 Hotline: 1800 0000</li>
      <li>🕒 Giờ làm việc: 8:00 – 18:00 (Thứ 2 – Thứ 7)</li>
    </ul>
  </div>

  <a href="index.php" class="btn-back">← Quay lại trang chủ</a>

</div>

<footer>
  <p>&copy; 2025 Tiffany & Co. | <a href="#">Chính sách bảo mật</a> | <a href="#">Điều khoản sử dụng</a></p>
</footer>

</body>
</html>

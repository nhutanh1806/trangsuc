<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đặt Lịch Hẹn - Tiffany & Co</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <style>
    /* ==== GIAO DIỆN TRANG ĐẶT LỊCH ==== */
    body {
      background-color: #f9f9f9;
      font-family: 'Times New Roman', serif;
      color: #333;
    }

    .footer-left {
    position: absolute;
    line-height: 3;
    left: 11%;
}

.footer-right {
    position: absolute;
    right: 8%;
    top: 158%;
}

a {
    color: black;
    letter-spacing: 1px;
}

.footer-container {
    border-top: 1px solid #ddd; /* Ã„â€˜Ã†Â°Ã¡Â»Âng ngang phÃƒÂ¢n cÃƒÂ¡ch */
    padding: 30px 0;
    text-align: center;
    background-color: #fefefe;
}



    .booking-container {
      max-width: 600px;
      margin: 80px auto;
      background-color: #ffffff;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      border: 1px solid #d6eaea;
    }

    .booking-container h2 {
      text-align: center;
      font-size: 28px;
      color: #0ABAB5; /* Tiffany Blue */
      margin-bottom: 20px;
      letter-spacing: 1px;
    }

    .booking-container p {
      text-align: center;
      color: #666;
      margin-bottom: 30px;
    }

    form label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
      color: #444;
    }

    form input, form textarea, form select {
      width: 100%;
      padding: 10px 12px;
      margin-bottom: 20px;
      border: 1px solid #cce7e7;
      border-radius: 8px;
      font-size: 16px;
      transition: all 0.3s ease;
      font-family: inherit;
    }

    form input:focus, form textarea:focus, form select:focus {
      border-color: #0ABAB5;
      outline: none;
      box-shadow: 0 0 5px rgba(10,186,181,0.3);
    }

    button {
      display: block;
      width: 100%;
      background-color: #0ABAB5;
      color: white;
      border: none;
      padding: 12px;
      border-radius: 10px;
      font-size: 18px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      letter-spacing: 1px;
    }

    button:hover {
      background-color: #099f9a;
    }

    .success-message {
      text-align: center;
      color: #0ABAB5;
      font-weight: bold;
      margin-top: 20px;
    }

    .back-link {
      display: block;
      text-align: center;
      margin-top: 15px;
      color: #0ABAB5;
      text-decoration: none;
    }

    .back-link:hover {
      text-decoration: underline;
    }


/* Tablet (768px - 1024px) */
@media screen and (max-width: 1024px) {
  .booking-container {
    max-width: 550px;
    margin: 60px auto;
    padding: 35px;
  }
  
  .booking-container h2 {
    font-size: 26px;
  }
  
  form input,
  form textarea,
  form select {
    font-size: 15px;
    padding: 9px 11px;
  }
  
  button {
    font-size: 17px;
    padding: 11px;
  }
  
  .footer-left,
  .footer-right {
    position: relative;
    left: auto;
    right: auto;
    top: auto;
  }
}

/* Mobile (dưới 768px) */
@media screen and (max-width: 768px) {
  /* Body */
  body {
    font-size: 14px;
  }
  
  /* Header - Sử dụng từ style.css */
  header .header-content {
    flex-direction: column;
    gap: 12px;
    padding: 15px;
  }
  
  header .logo {
    font-size: 20px;
    text-align: center;
    margin-left: 0;
  }
  
  header nav {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 8px;
  }
  
  header nav a {
    font-size: 13px;
    margin-left: 0;
    padding: 5px 8px;
  }
  
  header nav span {
    width: 100%;
    text-align: center;
    font-size: 12px;
    margin-left: 0 !important;
  }
  
  /* Booking Container */
  .booking-container {
    max-width: 90%;
    margin: 40px auto;
    padding: 25px 20px;
    border-radius: 15px;
  }
  
  .booking-container h2 {
    font-size: 22px;
    margin-bottom: 15px;
  }
  
  .booking-container p {
    font-size: 14px;
    margin-bottom: 25px;
  }
  
  /* Form */
  form label {
    font-size: 14px;
    margin-bottom: 4px;
  }
  
  form input,
  form textarea,
  form select {
    font-size: 14px;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 6px;
  }
  
  form textarea {
    rows: 3;
  }
  
  /* Button */
  button {
    font-size: 16px;
    padding: 11px;
    border-radius: 8px;
  }
  
  /* Success Message & Back Link */
  .success-message {
    font-size: 14px;
    margin-top: 15px;
  }
  
  .back-link {
    font-size: 14px;
    margin-top: 12px;
  }
  
  /* Footer */
  .footer-container {
    padding: 25px 15px;
  }
  
  .footer-left,
  .footer-right {
    position: relative;
    left: auto;
    right: auto;
    top: auto;
    text-align: center;
    margin-bottom: 15px;
  }
  
  .footer-left p,
  .footer-right a {
    display: block;
    margin: 8px 0;
    font-size: 13px;
  }
  
  .footer-center .logo {
    font-size: 24px;
  }
}

/* Mobile nhỏ (dưới 480px) */
@media screen and (max-width: 480px) {
  /* Header */
  header .header-content {
    padding: 12px;
  }
  
  header .logo {
    font-size: 18px;
  }
  
  header nav a {
    font-size: 11px;
    padding: 4px 6px;
  }
  
  header nav span {
    font-size: 11px;
  }
  
  /* Booking Container */
  .booking-container {
    max-width: 95%;
    margin: 30px auto;
    padding: 20px 15px;
    border-radius: 12px;
  }
  
  .booking-container h2 {
    font-size: 20px;
    margin-bottom: 12px;
  }
  
  .booking-container p {
    font-size: 13px;
    margin-bottom: 20px;
  }
  
  /* Form */
  form label {
    font-size: 13px;
  }
  
  form input,
  form textarea,
  form select {
    font-size: 14px;
    padding: 9px;
    margin-bottom: 12px;
  }
  
  /* Button */
  button {
    font-size: 15px;
    padding: 10px;
  }
  
  /* Back Link */
  .back-link {
    font-size: 13px;
  }
  
  /* Footer */
  .footer-container {
    padding: 20px 12px;
  }
  
  .footer-left p,
  .footer-right a {
    font-size: 12px;
    margin: 6px 0;
  }
  
  .footer-center .logo {
    font-size: 20px;
  }
}

/* Fix cho touch devices */
@media (hover: none) {
  button:active {
    background-color: #099f9a;
    transform: scale(0.98);
  }
  
  .back-link:active {
    opacity: 0.7;
  }
  
  form input:active,
  form textarea:active,
  form select:active {
    border-color: #0ABAB5;
  }
}

/* Đảm bảo form elements responsive */
input,
textarea,
select {
  max-width: 100%;
}

/* Fix input date picker trên mobile */
input[type="date"],
input[type="tel"],
input[type="email"] {
  -webkit-appearance: none;
  font-size: 16px; /* Ngăn zoom trên iOS */
}

/* Fix select dropdown trên iOS */
select {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
  background-repeat: no-repeat;
  background-position: right 10px center;
  background-size: 20px;
  padding-right: 35px;
}
  </style>
</head>
<body>



  <!-- HEADER -->
  <header>
    <div class="container header-content">
      <h1 class="logo">TIFFANY <span>& CO</span></h1>
      <nav>
        <a href="../index.php">Trang chủ</a>
        <a href="gioithieu.php">Giới thiệu</a>
        <a href="sanpham.php">Sản phẩm</a>
        <a href="datlich.php">Liên hệ</a>
        <?php if (isset($_SESSION['username'])): ?>
          <span style="margin-left:20px;">Xin chào, <?= htmlspecialchars($_SESSION['username']) ?>!</span>
          <a href="login.php?action=logout" style="color:red; margin-left:10px;">Đăng xuất</a>
        <?php else: ?>
          <a href="login.php" style="margin-left:20px;">Đăng nhập</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>

  <!-- BOOKING FORM -->
  <div class="booking-container">
    <h2>ĐẶT LỊCH HẸN</h2>
    <p>Hãy để chúng tôi giúp bạn có một trải nghiệm tuyệt vời cùng Tiffany & Co.</p>

    <form action="xuly_datlich.php" method="POST">
      <label for="hoten">Họ và tên</label>
      <input type="text" id="hoten" name="hoten" placeholder="Nhập họ tên của bạn" required>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" placeholder="example@gmail.com" required>

      <label for="sdt">Số điện thoại</label>
      <input type="tel" id="sdt" name="sdt" placeholder="0123 456 789" required>

      <label for="ngay">Ngày hẹn</label>
      <input type="date" id="ngay" name="ngay" required>

      <label for="cua_hang">Chọn cửa hàng</label>
      <select id="cua_hang" name="cua_hang" required>
        <option value="">-- Chọn địa điểm --</option>
        <option value="Hà Nội">Tiffany & Co. - Hà Nội</option>
        <option value="TP.HCM">Tiffany & Co. - TP.HCM</option>
      </select>

      <label for="ghichu">Ghi chú</label>
      <textarea id="ghichu" name="ghichu" rows="4" placeholder="Ghi chú thêm (nếu có)"></textarea>

      <button type="submit">Xác Nhận Đặt Lịch</button>
    </form>

    <a href="../index.php" class="back-link">← Quay lại Trang chủ</a>
  </div>

  <!-- FOOTER -->
  <footer class="footer">
    <div class="footer-container">
      <div class="footer-left">
        <p>Change Location: <a href="#">Vietnam</a></p>
        <p>T&amp;Co. 2025</p>
      </div>
      <div class="footer-center">
        <h1 class="logo">T C</h1>
      </div>
      <div class="footer-right">
        <a href="https://www.instagram.com/tiffanyandco/">Instagram</a>
        <a href="https://x.com/TiffanyAndCo">Twitter</a>
        <a href="https://www.facebook.com/Tiffany/">Facebook</a>
        <a href="https://www.youtube.com/OfficialTiffanyAndCo">YouTube</a>
      </div>
    </div>
  </footer>

</body>
</html>

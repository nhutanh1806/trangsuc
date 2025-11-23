<?php
session_start();

// ====== CẤU HÌNH KẾT NỐI DATABASE ======
$servername = "localhost";
$username = "root";     // Tên tài khoản MySQL (mặc định XAMPP là "root")
$password = "";         // Mật khẩu MySQL (nếu có thì thêm vào)
$dbname = "tiffany_shop";

// ====== KẾT NỐI CSDL ======
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// ====== LẤY DỮ LIỆU TỪ FORM ======
$hoten = $_POST['hoten'] ?? '';
$email = $_POST['email'] ?? '';
$sdt = $_POST['sdt'] ?? '';
$ngay = $_POST['ngay'] ?? '';
$cua_hang = $_POST['cua_hang'] ?? '';
$ghichu = $_POST['ghichu'] ?? '';

// ====== KIỂM TRA DỮ LIỆU ======
if ($hoten && $email && $sdt && $ngay && $cua_hang) {
    // Sử dụng prepared statement để bảo mật
    $stmt = $conn->prepare("INSERT INTO lichhen (hoten, email, sdt, ngay, cua_hang, ghichu) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $hoten, $email, $sdt, $ngay, $cua_hang, $ghichu);
    $stmt->execute();

    // Đóng kết nối
    $stmt->close();
    $conn->close();

    // Hiển thị thông báo đẹp mắt
    echo '
    <!DOCTYPE html>
    <html lang="vi">
    <head>
      <meta charset="UTF-8">
      <title>Đặt Lịch Thành Công - Tiffany & Co</title>
      <style>
        body {
          font-family: "Times New Roman", serif;
          background-color: #f7fdfd;
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: center;
          height: 100vh;
          color: #333;
        }
        .success-box {
          background-color: #fff;
          padding: 40px 60px;
          border-radius: 16px;
          box-shadow: 0 4px 20px rgba(0,0,0,0.1);
          border: 1px solid #b2eaea;
          text-align: center;
        }
        h1 {
          color: #0ABAB5;
          font-size: 28px;
          margin-bottom: 15px;
        }
        p {
          font-size: 18px;
          margin-bottom: 30px;
        }
        a {
          display: inline-block;
          background-color: #0ABAB5;
          color: white;
          text-decoration: none;
          padding: 10px 20px;
          border-radius: 8px;
          transition: background-color 0.3s ease;
        }
        a:hover {
          background-color: #099f9a;
        }
      </style>
    </head>
    <body>
      <div class="success-box">
        <h1>ĐẶT LỊCH THÀNH CÔNG 🎉</h1>
        <p>Cảm ơn bạn, <b>' . htmlspecialchars($hoten) . '</b>!<br>
        Chúng tôi sẽ liên hệ xác nhận lịch hẹn qua email <b>' . htmlspecialchars($email) . '</b> sớm nhất.</p>
        <a href="../index.php">Quay lại Trang chủ</a>
      </div>
    </body>
    </html>
    ';
} else {
    echo '<script>alert("Vui lòng điền đầy đủ thông tin!"); window.history.back();</script>';
}
?>

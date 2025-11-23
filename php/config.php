<?php
$host = "localhost";       // Máy chủ
$dbname = "tiffany_shop";  // Tên database
$username = "root";        // User mặc định XAMPP
$password = "";            // Mật khẩu (thường để trống trên XAMPP)

try {
    // Tạo kết nối PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Kết nối thành công"; // Có thể dùng để test
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}
?>

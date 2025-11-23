<?php
session_start();
require_once '../php/config.php';

// Kiểm tra quyền admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php?error=' . urlencode('Bạn không có quyền truy cập.'));
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Trang quản trị - Admin Dashboard</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #f7f7f7;
    padding: 40px;
}
h1 {
    text-align: center;
    color: #0ABAB5;
}
.dashboard {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
    margin-top: 40px;
}
.card {
    background: white;
    width: 200px;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    transition: transform 0.2s, box-shadow 0.2s;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.2);
}
.card a {
    text-decoration: none;
    color: #0ABAB5;
    font-weight: bold;
    display: block;
    margin-top: 10px;
}
.card-icon {
    font-size: 40px;
    margin-bottom: 10px;
}
.logout {
    text-align: center;
    margin-top: 30px;
}
.logout a {
    background: #dc3545;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
}
.logout a:hover {
    background: #b02a37;
}
</style>
</head>
<body>

<h1>🛠️ Trang Quản Trị Admin</h1>

<div class="dashboard">
    <div class="card">
        <div class="card-icon">📦</div>
        <div>Quản lý sản phẩm</div>
        <a href="admin_products.php">Xem chi tiết</a>
    </div>
    <div class="card">
        <div class="card-icon">📄</div>
        <div>Quản lý đơn hàng</div>
        <a href="admin_orders.php">Xem chi tiết</a>
    </div>
    <div class="card">
        <div class="card-icon">👤</div>
        <div>Quản lý người dùng</div>
        <a href="admin_quanlynguoidung.php">Xem chi tiết</a>
    </div>

</div>

<div class="logout">
    <a href="../php/login.php?action=logout">Đăng xuất</a>
</div>

</body>
</html>

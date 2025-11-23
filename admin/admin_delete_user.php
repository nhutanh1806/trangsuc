<?php
session_start();
require_once '../php/config.php';

// Kiểm tra quyền admin nếu cần
// if (!isset($_SESSION['admin'])) { header("Location: admin_login.php"); exit; }

if (!isset($_GET['id'])) {
    die("Thiếu ID người dùng.");
}

$user_id = intval($_GET['id']);

// Xóa user
$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$user_id]);

// Chuyển về đúng trang quản lý
header("Location: admin_quanlynguoidung.php"); // nếu cùng thư mục
exit;

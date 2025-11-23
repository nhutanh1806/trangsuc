<?php
session_start();
require_once __DIR__ . '/../php/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: admin_login.php");
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($username === '' || $password === '') {
    header("Location: admin_login.php?error=" . urlencode('Nhập đầy đủ tên đăng nhập và mật khẩu'));
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ?");
$stmt->execute([$username]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$admin) {
    header("Location: admin_login.php?error=" . urlencode('Sai tên đăng nhập hoặc mật khẩu'));
    exit;
}

// Nếu password đã hash, dùng password_verify
if (password_verify($password, $admin['password'])) {
    $_SESSION['admin'] = $admin['username'];
    header("Location: admin_orders.php");
    exit;
}

// Nếu password plain text, so sánh trực tiếp
if ($password === $admin['password']) {
    $_SESSION['admin'] = $admin['username'];
    header("Location: admin_orders.php");
    exit;
}

// Sai password
header("Location: admin_login.php?error=" . urlencode('Sai tên đăng nhập hoặc mật khẩu'));
exit;

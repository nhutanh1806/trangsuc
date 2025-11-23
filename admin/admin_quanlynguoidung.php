<?php
session_start();
require_once '../php/config.php';

// Xử lý tìm kiếm
$keyword = $_GET['keyword'] ?? '';

if ($keyword) {
    $stmt = $pdo->prepare("SELECT * FROM users 
                           WHERE role = 'user' AND (fullname LIKE :kw OR email LIKE :kw OR username LIKE :kw)
                           ORDER BY created_at DESC");
    $stmt->execute(['kw' => "%$keyword%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM users WHERE role = 'user' ORDER BY created_at DESC");
}

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý khách hàng</title>
<style>
    body { font-family: Arial, sans-serif; background:#f6f6f6; margin:0; padding:20px;}
    h1 { text-align:center; color:#333;}
    form { text-align:center; margin-bottom:20px;}
    input[type="text"] {
        padding:8px; width:250px; border:1px solid #ccc; border-radius:4px;
    }
    button {
        padding:8px 12px; background:#007bff; color:white; border:none; border-radius:4px; cursor:pointer;
    }
    button:hover { background:#0056b3; }
    table { width:100%; border-collapse:collapse; background:white; border-radius:8px; overflow:hidden; }
    th, td { padding:26px 7px; border-bottom:1px solid #eee; text-align:left; }
    th { background:#007bff; color:white; }
    tr:hover { background:#f1f1f1; }
    a.btn {
        padding:6px 10px; border-radius:4px; color:white; text-decoration:none; margin-right:5px;
    }
    .btn-delete { background:#dc3545; }
    .btn-view { background:#28a745; }
    .btn-delete:hover { background:#b02a37; }
    .btn-view:hover { background:#1e7e34; }
    .container { max-width:1100px; margin:0 auto; }
</style>
</head>
<body>
<div class="container">
    <h1>Quản lý khách hàng</h1>

    

    <!-- Ô tìm kiếm -->
    <form method="GET">
        <input type="text" name="keyword" placeholder="Nhập tên, email hoặc username..." value="<?= htmlspecialchars($keyword) ?>">
        <button type="submit">Tìm kiếm</button>
        <a href="admin_quanlynguoidung.php" style="margin-left:10px;">🔄 Làm mới</a>
    </form>


    <table>
        <tr>
            <th>ID</th>
            <th>Tên đăng nhập</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>Điện thoại</th>
            <th>Địa chỉ</th>
            <th>Ngày đăng ký</th>
            <th>Thao tác</th>
        </tr>
        <?php if (count($users) > 0): ?>
            <?php foreach ($users as $u): ?>
            <tr>
                <td><?= htmlspecialchars($u['id']) ?></td>
                <td><?= htmlspecialchars($u['username']) ?></td>
                <td><?= htmlspecialchars($u['fullname'] ?? '') ?></td>
                <td><?= htmlspecialchars($u['email'] ?? '') ?></td>
                <td><?= htmlspecialchars($u['phone'] ?? '') ?></td>
                <td><?= htmlspecialchars($u['address'] ?? '') ?></td>
                <td><?= htmlspecialchars($u['created_at'] ?? '') ?></td>
                <td>
                    <a href="admin_view_orders.php?user_id=<?= $u['id'] ?>" class="btn btn-view">Xem đơn hàng</a>
                    <a href="admin_delete_user.php?id=<?= $u['id'] ?>" class="btn btn-delete" onclick="return confirm('Bạn chắc chắn muốn xóa người dùng này không?')">Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="8" style="text-align:center; color:#888;">Không tìm thấy người dùng nào.</td></tr>
        <?php endif; ?>
    </table>
    <a href="admin_dashboard.php">← Quay lại trang chủ</a>
</div>
</body>
</html>

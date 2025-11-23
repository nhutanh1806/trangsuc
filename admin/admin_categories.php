<?php
session_start();
require_once '../php/config.php'; // Kết nối CSDL

// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// ===============
// THÊM DANH MỤC
// ===============
if (isset($_POST['add'])) {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $imagePath = '';

    // Upload ảnh
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = '../image/';
        $filename = time() . '_' . basename($_FILES['image']['name']);
        $target = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $imagePath = $target;
        }
    }

    if ($name) {
        $stmt = $pdo->prepare("INSERT INTO categories (name, description, image) VALUES (?, ?, ?)");
        $stmt->execute([$name, $description, $imagePath]);
    }

    header('Location: admin_categories.php');
    exit;
}

// ===============
// XÓA DANH MỤC
// ===============
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: admin_categories.php');
    exit;
}

// ===============
// SỬA DANH MỤC
// ===============
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $imagePath = $_POST['old_image']; // giữ ảnh cũ nếu không upload mới

    // Upload ảnh mới (nếu có)
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = '../image/';
        $filename = time() . '_' . basename($_FILES['image']['name']);
        $target = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $imagePath = $target;
        }
    }

    $stmt = $pdo->prepare("UPDATE categories SET name = ?, description = ?, image = ? WHERE id = ?");
    $stmt->execute([$name, $description, $imagePath, $id]);

    header('Location: admin_categories.php');
    exit;
}

// LẤY DANH MỤC
$stmt = $pdo->query("SELECT * FROM categories ORDER BY id DESC");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Nếu đang sửa
$editCategory = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    $editCategory = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý danh mục - Tiffany & Co</title>
<style>
body {
  font-family: Arial, sans-serif;
  background: #f4f6f9;
  padding: 30px;
}
h1 { text-align: center; color: #0a5f6b; }

form {
  background: #fff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
  max-width: 500px;
  margin: 20px auto;
}
input, textarea {
  width: 100%;
  padding: 8px;
  margin: 6px 0;
  border: 1px solid #ccc;
  border-radius: 4px;
}
button {
  background: #0a5f6b;
  color: white;
  padding: 8px 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
button:hover { background: #128aa1; }

table {
  width: 90%;
  margin: 20px auto;
  border-collapse: collapse;
  background: #fff;
  box-shadow: 0 0 5px rgba(0,0,0,0.1);
}
th, td {
  padding: 10px;
  border: 1px solid #ddd;
  text-align: center;
}
th { background: #0a5f6b; color: #fff; }
img { width: 80px; border-radius: 4px; }

a {
  text-decoration: none;
  color: #0a5f6b;
  font-weight: bold;
}
a:hover { text-decoration: underline; }
a.btn-del { color: red; }
a.btn-del:hover { text-decoration: underline; }
</style>
</head>
<body>

<h1>Quản lý danh mục sản phẩm</h1>

<?php if ($editCategory): ?>
  <!-- FORM SỬA DANH MỤC -->
  <form method="POST" enctype="multipart/form-data">
    <h3>✏️ Sửa danh mục</h3>
    <input type="hidden" name="id" value="<?= $editCategory['id'] ?>">
    <input type="hidden" name="old_image" value="<?= htmlspecialchars($editCategory['image']) ?>">
    <input type="text" name="name" value="<?= htmlspecialchars($editCategory['name']) ?>" required>
    <textarea name="description"><?= htmlspecialchars($editCategory['description']) ?></textarea>

    <p>Ảnh hiện tại:</p>
    <?php if ($editCategory['image']): ?>
      <img src="<?= htmlspecialchars($editCategory['image']) ?>" alt="" style="width:100px;">
    <?php else: ?>
      <p><i>Chưa có ảnh</i></p>
    <?php endif; ?>

    <p>Chọn ảnh mới (nếu muốn thay):</p>
    <input type="file" name="image" accept="image/*">

    <button type="submit" name="update">Cập nhật</button>
    <a href="admin_categories.php">Hủy</a>
  </form>

<?php else: ?>
  <!-- FORM THÊM DANH MỤC -->
  <form method="POST" enctype="multipart/form-data">
    <h3>➕ Thêm danh mục mới</h3>
    <input type="text" name="name" placeholder="Tên danh mục" required>
    <textarea name="description" placeholder="Mô tả"></textarea>
    <input type="file" name="image" accept="image/*">
    <button type="submit" name="add">Thêm danh mục</button>
  </form>
<?php endif; ?>

<!-- DANH SÁCH DANH MỤC -->
<table>
  <tr>
    <th>ID</th>
    <th>Tên danh mục</th>
    <th>Ảnh</th>
    <th>Mô tả</th>
    <th>Hành động</th>
  </tr>
  <?php foreach ($categories as $c): ?>
  <tr>
    <td><?= $c['id'] ?></td>
    <td><?= htmlspecialchars($c['name']) ?></td>
    <td>
      <?php if ($c['image']): ?>
        <img src="<?= htmlspecialchars($c['image']) ?>" alt="<?= htmlspecialchars($c['name']) ?>">
      <?php else: ?>Không có ảnh<?php endif; ?>
    </td>
    <td><?= htmlspecialchars($c['description']) ?></td>
    <td>
      <a href="?edit=<?= $c['id'] ?>">Sửa</a> |
      <a href="?delete=<?= $c['id'] ?>" class="btn-del" onclick="return confirm('Xóa danh mục này?');">Xóa</a>
    </td>
  </tr>
  <?php endforeach; ?>
</table>

<p style="text-align:center;">
  <a href="index.php">← Quay lại trang chủ</a>
</p>

</body>
</html>

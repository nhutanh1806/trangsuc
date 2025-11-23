<?php
session_start();
require_once('../php/config.php');
 // Kết nối PDO

// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// =======================
// THÊM SẢN PHẨM
// =======================
if (isset($_POST['add'])) {
    $name = trim($_POST['name']);
    $slug = trim($_POST['slug']);
    $description = trim($_POST['description']);
    $price = $_POST['price'];
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

    $stmt = $pdo->prepare("INSERT INTO products (name, slug, description, price, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $slug, $description, $price, $imagePath]);

    header('Location: admin_products.php');
    exit;
}

// =======================
// XÓA SẢN PHẨM
// =======================
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: admin_products.php');
    exit;
}

// =======================
// SỬA SẢN PHẨM
// =======================
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $name = trim($_POST['name']);
    $slug = trim($_POST['slug']);
    $description = trim($_POST['description']);
    $price = $_POST['price'];
    $imagePath = $_POST['old_image'];

    if (!empty($_FILES['image']['name'])) {
        $uploadDir = '../image/';
        $filename = time() . '_' . basename($_FILES['image']['name']);
        $target = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $imagePath = $target;
        }
    }

    $stmt = $pdo->prepare("UPDATE products SET name=?, slug=?, description=?, price=?, image=? WHERE id=?");
    $stmt->execute([$name, $slug, $description, $price, $imagePath, $id]);

    header('Location: admin_products.php');
    exit;
}

// =======================
// LẤY DANH SÁCH SẢN PHẨM
// =======================
$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Lấy sản phẩm cần sửa
$editProduct = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $editProduct = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý sản phẩm - Tiffany & Co</title>
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
  max-width: 600px;
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
  width: 95%;
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
header {
  background-color: #ffffff;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
  padding: 0 50px;
  height: 80px;
  display: flex;
  align-items: center;
  justify-content: center;
  position: sticky;
  top: 0;
  z-index: 10;
}

.header-container {
  width: 100%;
  max-width: 1200px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.logo {
  font-family: 'Georgia', serif;
  font-size: 28px;
  font-weight: bold;
  color: #b0b0b0;
  margin: 0;
  cursor: pointer;
}

.logo span {
  color: #81D8D0;
  font-weight: normal;
}

nav {
  display: flex;
  align-items: center;
  gap: 25px;
}

nav a {
  color: #333;
  text-decoration: none;
  font-size: 16px;
  font-weight: 500;
  transition: color 0.3s ease;
  line-height: 1;
}

nav a:hover,
nav a.active {
  color: #009B9A;
}

.user-info {
  color: #555;
  font-weight: 500;
  margin-left: 10px;
}

.logout {
  color: red !important;
  font-weight: bold;
  margin-left: 10px;
}

</style>
</head>
<body>
  <header>
  <div class="container header-content">
    <h1 class="logo" onclick="window.location.href='../index.php'" style="cursor:pointer;">
      TIFFANY <span>& CO</span>
    </h1>
  </div>
</header>

<h1>Quản lý sản phẩm</h1>

<?php if ($editProduct): ?>
  <form method="POST" enctype="multipart/form-data">
    <h3>✏️ Sửa sản phẩm</h3>
    <input type="hidden" name="id" value="<?= $editProduct['id'] ?>">
    <input type="hidden" name="old_image" value="<?= htmlspecialchars($editProduct['image']) ?>">

    <label>Tên sản phẩm:</label>
    <input type="text" name="name" value="<?= htmlspecialchars($editProduct['name']) ?>" required>

    <label>Slug (đường dẫn):</label>
    <input type="text" name="slug" value="<?= htmlspecialchars($editProduct['slug']) ?>">

    <label>Mô tả:</label>
    <textarea name="description"><?= htmlspecialchars($editProduct['description']) ?></textarea>

    <label>Giá:</label>
    <input type="number" name="price" value="<?= $editProduct['price'] ?>" required>

    <p>Ảnh hiện tại:</p>
    <?php if ($editProduct['image']): ?>
      <img src="<?= htmlspecialchars($editProduct['image']) ?>" alt="" style="width:100px;">
    <?php else: ?>
      <p><i>Chưa có ảnh</i></p>
    <?php endif; ?>

    <p>Chọn ảnh mới (nếu muốn thay):</p>
    <input type="file" name="image" accept="image/*">

    <button type="submit" name="update">Cập nhật</button>
    <a href="admin_products.php">Hủy</a>
  </form>

<?php else: ?>
  <form method="POST" enctype="multipart/form-data">
    <h3>➕ Thêm sản phẩm mới</h3>

    <label>Tên sản phẩm:</label>
    <input type="text" name="name" required>

    <label>Slug (đường dẫn ngắn):</label>
    <input type="text" name="slug">

    <label>Mô tả:</label>
    <textarea name="description"></textarea>

    <label>Giá:</label>
    <input type="number" name="price" required>

    <label>Ảnh sản phẩm:</label>
    <input type="file" name="image" accept="image/*">

    <button type="submit" name="add">Thêm sản phẩm</button>
  </form>
<?php endif; ?>
  <a href="admin_dashboard.php">← Quay lại trang chủ</a>

<table>
  <tr>
    <th>ID</th>
    <th>Tên sản phẩm</th>
    <th>Ảnh</th>
    <th>Giá</th>
    <th>Slug</th>
    <th>Hành động</th>
  </tr>
  <?php foreach ($products as $p): ?>
  <tr>
    <td><?= $p['id'] ?></td>
    <td><?= htmlspecialchars($p['name']) ?></td>
    <td>
      <?php if ($p['image']): ?>
        <img src="<?= htmlspecialchars($p['image']) ?>" alt="">
      <?php else: ?>Không có ảnh<?php endif; ?>
    </td>
    <td><?= number_format($p['price'], 0, ',', '.') ?>₫</td>
    <td><?= htmlspecialchars($p['slug']) ?></td>
    <td>
      <a href="?edit=<?= $p['id'] ?>">Sửa</a> |
      <a href="?delete=<?= $p['id'] ?>" class="btn-del" onclick="return confirm('Xóa sản phẩm này?');">Xóa</a>
    </td>
  </tr>
  <?php endforeach; ?>
</table>

<p style="text-align:center;">
</p>

</body>
</html>

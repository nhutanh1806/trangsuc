<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: admin_login.php");
  exit;
}

// ====== KẾT NỐI DATABASE ======
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tiffany_shop"; // đúng tên CSDL bạn tạo

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Kết nối thất bại: " . $conn->connect_error);
}

// ====== XÓA LỊCH HẸN ======
if (isset($_GET['delete'])) {
  $id = intval($_GET['delete']);
  $conn->query("DELETE FROM lichhen WHERE id = $id");
  header("Location: admin_lichhen.php");
  exit;
}

// ====== TÌM KIẾM LỊCH HẸN ======
$search = $_GET['search'] ?? '';
if ($search) {
  $stmt = $conn->prepare("SELECT * FROM lichhen 
                          WHERE hoten LIKE ? 
                          OR email LIKE ? 
                          OR ngay LIKE ?
                          ORDER BY ngay_dat DESC");
  $param = "%$search%";
  $stmt->bind_param("sss", $param, $param, $param);
  $stmt->execute();
  $result = $stmt->get_result();
} else {
  $result = $conn->query("SELECT * FROM lichhen ORDER BY ngay_dat DESC");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Quản Lý Lịch Hẹn - Tiffany & Co</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: 'Times New Roman', serif;
      background-color: #f7fdfd;
      color: #333;
      margin: 0;
      padding: 0;
    }
    header {
      background-color: #0ABAB5;
      color: white;
      padding: 20px;
      text-align: center;
      position: relative;
    }
    h1 {
      margin: 0;
      font-size: 26px;
      letter-spacing: 1px;
    }
    .container {
      max-width: 1100px;
      margin: 40px auto;
      background: #fff;
      border-radius: 15px;
      padding: 20px 30px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      padding: 12px 10px;
      border-bottom: 1px solid #d6ecec;
      text-align: center;
    }
    th {
      background-color: #e5f7f7;
      color: #0ABAB5;
    }
    tr:hover {
      background-color: #f0fafa;
    }
    .btn-delete {
      background-color: #ff6666;
      color: white;
      padding: 6px 12px;
      border-radius: 8px;
      text-decoration: none;
      transition: 0.3s;
    }
    .btn-delete:hover {
      background-color: #ff4c4c;
    }
    .btn-back {
      display: inline-block;
      margin-top: 15px;
      text-decoration: none;
      color: #0ABAB5;
      font-weight: bold;
    }
    .btn-back:hover {
      text-decoration: underline;
    }
    form.search {
      text-align: center;
      margin-bottom: 20px;
    }
    input[type="text"] {
      padding: 8px 10px;
      width: 300px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    button {
      padding: 8px 15px;
      border: none;
      background: #0ABAB5;
      color: white;
      border-radius: 6px;
      cursor: pointer;
    }
    button:hover {
      background: #099f9a;
    }
    .btn-showall {
      padding: 8px 12px;
      background: #ccc;
      color: black;
      border-radius: 6px;
      text-decoration: none;
      margin-left: 8px;
    }
  </style>
</head>
<body>

<header>
  <h1>QUẢN LÝ LỊCH HẸN - TIFFANY & CO</h1>
  <div style="position:absolute; top:20px; right:30px;">
    <a href="admin_logout.php" style="color:white; text-decoration:none; background:#ff6666; padding:6px 12px; border-radius:8px;">Đăng xuất</a>
  </div>
</header>

<div class="container">
  <h2 style="text-align:center; color:#0ABAB5;">Danh Sách Lịch Hẹn</h2>

  <!-- Ô TÌM KIẾM -->
  <form method="GET" class="search">
    <input type="text" name="search" placeholder="Tìm theo tên, email hoặc ngày (YYYY-MM-DD)" 
           value="<?= htmlspecialchars($search) ?>">
    <button type="submit">🔍 Tìm kiếm</button>
    <a href="admin_lichhen.php" class="btn-showall">🧾 Xem tất cả</a>
  </form>

  <?php if ($result && $result->num_rows > 0): ?>
    <table>
      <tr>
        <th>ID</th>
        <th>Họ Tên</th>
        <th>Email</th>
        <th>SĐT</th>
        <th>Ngày Hẹn</th>
        <th>Cửa hàng</th>
        <th>Ghi Chú</th>
        <th>Ngày Đặt</th>
        <th>Xóa</th>
      </tr>
      <?php while($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['hoten']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['sdt']) ?></td>
        <td><?= htmlspecialchars($row['ngay']) ?></td>
        <td><?= htmlspecialchars($row['cua_hang']) ?></td>
        <td><?= htmlspecialchars($row['ghichu']) ?></td>
        <td><?= htmlspecialchars($row['ngay_dat']) ?></td>
        <td><a href="?delete=<?= $row['id'] ?>" class="btn-delete" onclick="return confirm('Bạn có chắc muốn xóa lịch hẹn này?')">Xóa</a></td>
      </tr>
      <?php endwhile; ?>
    </table>
  <?php else: ?>
    <p style="text-align:center;">Không có lịch hẹn nào hoặc không tìm thấy kết quả phù hợp.</p>
  <?php endif; ?>

  <div style="text-align:center;">
    <a href="../php/index.php" class="btn-back">← Quay lại trang chủ</a>
  </div>
</div>

</body>
</html>
<?php $conn->close(); ?>

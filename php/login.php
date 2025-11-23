<?php
session_start();
require_once __DIR__ . '/config.php';

$action = $_GET['action'] ?? '';
$error = '';
$success = '';

// ===========================
// LOGOUT
// ===========================
if ($action === 'logout') {
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params['path'], $params['domain'],
            $params['secure'], $params['httponly']
        );
    }
    session_destroy();
    header('Location: login.php');
    exit;
}

// ===========================
// LOGIN
// ===========================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === '') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username && $password) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Kiểm tra password
           if (password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];         // ✅ THÊM DÒNG NÀY
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    // Chuyển hướng theo role
    if ($user['role'] === 'admin') {
        header('Location: ../admin/admin_dashboard.php');
    } else {
        header('Location: ../index.php');
    }
    exit;
}

            } else {
                $error = 'Sai mật khẩu!';
            }
        } else {
            $error = 'Không tìm thấy tài khoản này!';
        }
    } else {
        $error = 'Vui lòng nhập đầy đủ thông tin!';
    }


// ===========================
// REGISTER
// ===========================
// ===========================
// REGISTER
// ===========================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'register') {
    $newUser = trim($_POST['username'] ?? '');
    $newPass = trim($_POST['password'] ?? '');
    $confirm = trim($_POST['confirm'] ?? '');
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');

    if (!$newUser || !$newPass || !$confirm || !$fullname || !$email || !$phone || !$address) {
        $error = 'Vui lòng điền đầy đủ thông tin!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email không hợp lệ!';
    } elseif ($newPass !== $confirm) {
        $error = 'Mật khẩu xác nhận không khớp!';
    } else {
        // Kiểm tra username trùng
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$newUser]);
        if ($stmt->fetch()) {
            $error = 'Tên đăng nhập đã tồn tại!';
        } else {
            $hash = password_hash($newPass, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password, role, fullname, email, phone, address) VALUES (?, ?, 'user', ?, ?, ?, ?)");
            if ($stmt->execute([$newUser, $hash, $fullname, $email, $phone, $address])) {
                $success = 'Đăng ký thành công! Hãy đăng nhập.';
            } else {
                $error = 'Lỗi khi đăng ký!';
            }
        }
    }
}


// ===========================
// FORGOT PASSWORD
// ===========================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'forgot') {
    $username = trim($_POST['username'] ?? '');
    $newpass = trim($_POST['newpass'] ?? '');
    $confirm = trim($_POST['confirm'] ?? '');

    if (!$username || !$newpass || !$confirm) {
        $error = 'Vui lòng điền đầy đủ thông tin!';
    } elseif ($newpass !== $confirm) {
        $error = 'Mật khẩu mới và xác nhận không khớp!';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $error = 'Không tìm thấy tài khoản này!';
        } else {
            $hash = password_hash($newpass, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = ?");
            if ($stmt->execute([$hash, $username])) {
                $success = 'Cập nhật mật khẩu thành công! Quay lại đăng nhập trong 3 giây...';
                echo "<script>
                        setTimeout(function() {
                            window.location.href = 'login.php';
                        }, 3000);
                      </script>";
            } else {
                $error = 'Lỗi khi cập nhật mật khẩu!';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Tiffany & Co</title>
<style>
/* Các style giống như bạn gửi trước */
body { background-color: #d1e8e4; display:flex; justify-content:center; align-items:center; height:100vh; margin:0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;}
form { background-color:#f7fcfc; padding:40px; border-radius:12px; width:360px; box-shadow:0 8px 20px rgba(83,248,248,0.25);}
input,button { width:100%; padding:12px; margin-bottom:15px; border-radius:8px;}
button { background-color:#88f7f7; color:white; border:none; font-weight:700; cursor:pointer;}
button:hover { background-color:#85cdcd;}
.error { color:red; text-align:center; }
.success { color:green; text-align:center; }
.links { text-align:center; font-size:14px;}
.links a { color:#0ca3a3; text-decoration:none; margin:0 8px;}
.links a:hover { text-decoration:underline;}
</style>
</head>
<body>

<?php if (isset($_SESSION['username'])): ?>
<div>
<h2>Xin chào, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
<p>Role: <?= htmlspecialchars($_SESSION['role']) ?></p>
<a href="?action=logout"><button>Đăng xuất</button></a>
<?php if($_SESSION['role'] === 'admin'): ?>
<p><a href="../admin/admin_dashboard.php">→ Quản lý đơn hàng</a></p>
<?php else: ?>
<p><a href="../index.php">→ Trang chủ</a></p>
<?php endif; ?>
</div>
<?php else: ?>

<?php if ($action === 'register'): ?>
<form method="POST" action="?action=register">
<h2>Đăng ký tài khoản</h2>
<?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
<?php if ($success): ?><p class="success"><?= htmlspecialchars($success) ?></p><?php endif; ?>

<input type="text" name="fullname" placeholder="Họ và tên" required>
<input type="email" name="email" placeholder="Email" required>
<input type="text" name="phone" placeholder="Số điện thoại" required>
<input type="text" name="address" placeholder="Địa chỉ" required>

<hr style="border:0; border-top:1px solid #ccc; margin:15px 0;">

<input type="text" name="username" placeholder="Tên đăng nhập" required>
<input type="password" name="password" placeholder="Mật khẩu" required>
<input type="password" name="confirm" placeholder="Xác nhận mật khẩu" required>
<button type="submit">Đăng ký</button>
<div class="links">
<a href="login.php">Đăng nhập</a>
</div>
</form>


<?php elseif ($action === 'forgot'): ?>
<form method="POST" action="?action=forgot">
<h2>Quên mật khẩu</h2>
<?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
<?php if ($success): ?><p class="success"><?= htmlspecialchars($success) ?></p><?php endif; ?>
<input type="text" name="username" placeholder="Tên đăng nhập" required>
<input type="password" name="newpass" placeholder="Mật khẩu mới" required>
<input type="password" name="confirm" placeholder="Nhập lại mật khẩu mới" required>
<button type="submit">Cập nhật mật khẩu</button>
<div class="links">
<a href="login.php">← Quay lại đăng nhập</a>
</div>
</form>

<?php else: ?>
<form method="POST" action="">
<h2>Đăng nhập</h2>
<?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
<?php if ($success): ?><p class="success"><?= htmlspecialchars($success) ?></p><?php endif; ?>
<input type="text" name="username" placeholder="Tên đăng nhập" required>
<input type="password" name="password" placeholder="Mật khẩu" required>
<button type="submit">Đăng nhập</button>
<div class="links">
<a href="?action=register">Đăng ký</a> | 
<a href="?action=forgot">Quên mật khẩu</a>
</div>
</form>
<?php endif; ?>

<?php endif; ?>

</body>
</html>

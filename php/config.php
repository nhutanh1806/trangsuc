<?php
// LƯU Ý: Đây là cấu hình cho PostgreSQL (pgsql), KHÔNG phải MySQL (mysql)

$db_host = 'dpg-d4hahm2li9vc73e361s0-a'; 
$db_name = 'qibh_n097';
$db_user = 'admin';
// Đảm bảo mật khẩu không có dấu cách thừa
$db_pass = 'YmkOyEH2dvu0jvcWMy8M9p8tMQSaPDICT';

try {
    // QUAN TRỌNG: Thay đổi DSN từ mysql: sang pgsql:
    $dsn = "pgsql:host=$db_host;dbname=$db_name";
    
    $pdo = new PDO($dsn, $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Kết nối thành công!"; // Sau khi test thành công thì xóa dòng này
} catch (PDOException $e) {
    // Lỗi kết nối thất bại
    die("Lỗi kết nối database: " . $e->getMessage());
}
?>

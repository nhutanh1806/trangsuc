<?php
session_start();

// Đảm bảo request là POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);

    // Dữ liệu sản phẩm mẫu
    $products = [
        1 => ['id' => 1, 'name' => 'Nhẫn Tiffany T', 'price' => 8900000],
        2 => ['id' => 2, 'name' => 'Nhẫn Nơ Bạc', 'price' => 6500000],
        3 => ['id' => 3, 'name' => 'Nhẫn Kim Cương', 'price' => 12500000],
        4 => ['id' => 4, 'name' => 'Chiếc nhẫn Bạc Trắng', 'price' => 7200000],
        5 => ['id' => 5, 'name' => 'Nhẫn Kim Cương Trắng', 'price' => 15900000],
    ];

    // Kiểm tra sản phẩm có tồn tại
    if (!isset($products[$id])) {
        echo json_encode(['status' => 'error', 'message' => 'Sản phẩm không tồn tại!']);
        exit;
    }

    // Thêm vào giỏ hàng
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity']++;
    } else {
        $_SESSION['cart'][$id] = [
            'id' => $products[$id]['id'],
            'name' => $products[$id]['name'],
            'price' => $products[$id]['price'],
            'quantity' => 1
        ];
    }

    // Tính tổng số lượng sản phẩm trong giỏ
    $total = array_sum(array_column($_SESSION['cart'], 'quantity'));

    echo json_encode([
        'status' => 'success',
        'message' => $products[$id]['name'] . ' đã được thêm vào giỏ hàng!',
        'total' => $total
    ]);
    exit;
}

// Nếu không phải POST
echo json_encode(['status' => 'error', 'message' => 'Yêu cầu không hợp lệ!']);

<?php
session_start();

// Kết nối cơ sở dữ liệu (sử dụng MySQLi)
require($_SERVER['DOCUMENT_ROOT'] . '/ASM/Admin/AdminConner.php');

if (!isset($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
    die('Your cart is empty. Please add some products first.');
}

// Thay thế user_id này bằng ID của người dùng đăng nhập
$user_id = 1; // Giả sử ID người dùng là 1

try {
    // Kiểm tra kết nối cơ sở dữ liệu
    if (!$conn) {
        throw new Exception('Database connection is not available.');
    }

    // Tính tổng giá trị đơn hàng
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['quantity'] * $item['product_price'];
    }

    // Lưu đơn hàng vào bảng `orders` (sử dụng MySQLi)
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total, status) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $user_id, $total, $status);
    $status = 'Pending';
    $stmt->execute();
    $order_id = $conn->insert_id;

    // Lưu chi tiết đơn hàng vào bảng `order_details` (sử dụng MySQLi)
    $stmt = $conn->prepare("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price);

    foreach ($_SESSION['cart'] as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        $price = $item['product_price'];
        $stmt->execute();
    }

    // Xóa giỏ hàng sau khi đặt hàng thành công
    unset($_SESSION['cart']);

    // Chuyển hướng về trang xác nhận
    header('Location: /ASM/Shop/Shop_child/Shop_1.php?order_id=' . $order_id);
    exit();
} catch (Exception $e) {
    die("Error processing order: " . $e->getMessage());
}

?>
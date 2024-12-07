<?php
session_start();

// Connect to the database (using MySQLi)
require($_SERVER['DOCUMENT_ROOT'] . '/ASM/Admin/AdminConner.php');

if (!isset($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
    die('Your cart is empty. Please add some products first.');
}

// Replace this user_id with the ID of the logged-in user
$user_id = 1; // Assume the user's ID is 1

try {
    // Check database connection
    if (!$conn) {
        throw new Exception('Database connection is not available.');
    }

    // Calculate the total order value
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['quantity'] * $item['product_price'];
    }

    // Save the order to the `orders` table (using MySQLi)
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total, status) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $user_id, $total, $status);
    $status = 'Pending';
    $stmt->execute();
    $order_id = $conn->insert_id;

    // Save order details to the `order_details` table (using MySQLi)
    $stmt = $conn->prepare("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price);

    foreach ($_SESSION['cart'] as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        $price = $item['product_price'];
        $stmt->execute();
    }

    // Clear the cart after successfully placing the order
    unset($_SESSION['cart']);

    // Redirect to the confirmation page
    header('Location: /ASM/Shop/Shop_child/Shop_1.php?order_id=' . $order_id);
    exit();
} catch (Exception $e) {
    die("Error processing order: " . $e->getMessage());
}

?>
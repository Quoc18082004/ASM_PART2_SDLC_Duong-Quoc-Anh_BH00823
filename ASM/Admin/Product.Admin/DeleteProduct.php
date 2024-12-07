<?php
// Kết nối MySQL
require($_SERVER['DOCUMENT_ROOT'] . '/ASM/Admin/AdminConner.php');

// Kiểm tra nếu có 'id' trong URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header('Location: http://localhost/ASM/Admin/Product.php#?page_layout=danhsach');
        exit();
    } else {
        echo 'error';
    }

    $stmt->close();
} else {
    echo "ID không hợp lệ!";
}

$conn->close();
?>
<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/ASM/Admin/AdminConner.php');

// Kiểm tra xem `id` có được gửi qua URL hay không
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = intval($_GET['id']);

    // Câu lệnh SQL để xóa người dùng
    $sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            // Xóa thành công
            header("Location: http://localhost/ASM/Admin/Admin_User.php.php?message=success");
        } else {
            // Lỗi khi thực thi
            header("Location: ../Admin_User.php?message=error");
        }
        $stmt->close();
    } else {
        // Lỗi khi chuẩn bị câu lệnh SQL
        header("Location: ../Admin_User.php?message=error");
    }
} else {
    // Nếu không có ID hợp lệ
    header("Location: ../Admin_User.php?message=invalid");
}
$conn->close();
?>

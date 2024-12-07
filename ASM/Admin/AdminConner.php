<?php
$servername = "localhost"; // Địa chỉ server
$username = "root";        // Tên đăng nhập
$password = "";            // Mật khẩu
$dbname = "quoc_anhbh00823-1"; // Tên cơ sở dữ liệu

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}
?>
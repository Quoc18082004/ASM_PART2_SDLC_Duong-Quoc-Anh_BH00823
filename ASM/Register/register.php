<?php
require($_SERVER['DOCUMENT_ROOT'] . '/ASM/Admin/AdminConner.php'); // Kết nối CSDL

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $email = $_POST['email'];
    $password = $_POST['password']; // Lưu trực tiếp mật khẩu không mã hóa
    $Name = $_POST['Name'];
    $isAdmin = 0; // Mặc định tài khoản không phải admin

    // Kiểm tra dữ liệu không được để trống
    if (!empty($email) && !empty($password) && !empty($Name)) {
        // Thêm tài khoản vào bảng `users`
        $sql = "INSERT INTO `users` (`email`, `password`, `Fullname`, `isAdmin`) VALUES ('$email', '$password', '$Name', '$isAdmin')";

        if ($conn->query($sql) === TRUE) {
            echo "Tài khoản đã được đăng ký thành công!";
            // Chuyển hướng tới trang đăng nhập
            header("Location: ../Login/login.php?register_success=1");
            exit;
        } else {
            echo "Lỗi khi lưu dữ liệu: {$sql} " . $conn->error;
        }
    } else {
        echo "Vui lòng nhập đầy đủ thông tin.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="../Register/register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
</head>

<body>
    <!-- Header -->
    <div id="Header-Container">
        <div id="Header-Nav">
            <div class="Header-logo">
                <a href="/Home/Home.html"><span class="Auto" style="color: red;">Auto</span>Drive</a>
            </div>
            <div class="Header-icon">
                <div class="Header-item">
                    <a href="#"><i class="fa-regular fa-user"></i></a>
                </div>
                <div class="divider"></div>
                <div class="Header-item">
                    <a href="#"><i class="fa fa-search"></i></a>
                </div>
                <div class="Header-item">
                    <a href="#"><input type="search" placeholder="Explore Gearz"></a>
                </div>
                <div class="divider"></div>
                <div class="Header-item">
                    <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Register -->
    <div id="register">
        <form method="POST" class="register-item">
            <h1>Sign Up</h1>

            <!-- Hiển thị lỗi nếu có -->
            <?php if (isset($error)): ?>
                <p style="color: red;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <div class="register-sign-up Input-text">
                <label for="email">Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="register-sign-up Input-text">
                <label for="Name">Name</label>
                <input type="text" name="Name" required>
            </div>
            <div class="register-sign-up Input-text">
                <label for="password">Password</label>
                <input type="password" name="password" required>
            </div>
            <div class="register-sign-up Sign-Up">
                <button type="submit">Sign Up</button>
            </div>
            <div class="register-sign-up Log-In">
                <span>Already have an account?</span>
                <a href="../Login/login.php">Log In</a>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <div id="Footer">
        <div class="footer-item">
            <div class="footer-item-end">
                <div class="AutoMaster">
                    <a href="/Home/Home.html"><span class="Auto" style="color: red;">Auto</span>Drive</a>
                    <p>AutoMaster Parts Co., Ltd.</p>
                </div>
                <p>Committed to delivering comprehensive auto parts solutions for enthusiasts and everyday drivers,
                    enhancing safety and convenience.</p>
                <div class="hover-item"><a href="#">Btecfpt@gmail.com</a></div>
            </div>
            <div class="footer-item-end">
                <h2>Need Help?</h2>
                <p>Monday to Friday 9AM - 5PM <br>Saturday & Sunday 10AM to 12PM.</p>
                <div class="hover-item"><a href="#">Btecfpt@gmail.com</a></div>
            </div>
        </div>
        <div class="footer-item-2">
            <p>&copy; 2024 <span class="Auto" style="color: red;">Auto</span>Drive</p>
            <p>Designed by MrQuocAnh. Powered by Teacher Hanh.</p>
        </div>
    </div>
</body>

</html>
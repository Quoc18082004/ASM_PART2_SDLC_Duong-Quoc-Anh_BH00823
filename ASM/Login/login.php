<?php
require($_SERVER['DOCUMENT_ROOT'] . '/ASM/Admin/AdminConner.php'); // Kết nối CSDL
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($conn->connect_error) die("Kết nối thất bại");

    $stmt = $conn->prepare("SELECT * FROM users WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && $password === $user['Password']) {
        $_SESSION = ['user_id' => $user['user_id'], 'email' => $user['Email'], 'isAdmin' => $user['IsAdmin']];
        header("Location: " . ($user['IsAdmin'] ? "../Admin/Admin.php" : "../Shop/Shop_child/Shop_1.php"));
        exit;
    }

    echo $user ? "Mật khẩu không đúng!" : "Email không tồn tại!";
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../Login/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div id="Header-Container">
        <!-- Header Nav -->
        <div id="Header-Nav">
            <div class="Header-logo">
                <a href="/Home/Home.html"><span class="Auto" style="color: red; ">Auto</span>Drive</a>
            </div>
            <div class="Header-icon">
                <div class="Header-item">
                    <a href="http://localhost/ASM/Login/login.php"><i class="fa-regular fa-user"></i> Login</a>
                </div>
                <div class="divider"></div>
                <div class="Header-item">
                    <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div id="title-login">
        <form action="login.php" method="POST" class="login-input">
            <h1>Log In</h1>

            <div class="title-login-1 email">
                <label for="email">Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="title-login-1 password">
                <label for="password">Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="title-login-1 Log-In">
                <button type="submit">Log In</button>
            </div>

            <div class="title-login-1 Sign-Up">
                <span>Don't have an account?</span>
                <a href="../Register/register.php">Sign Up</a>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <div id="Footer">
        <div class="footer-item">
            <div class="footer-item-1">
                <div class="footer-item-end">
                    <div class="AutoMaster">
                        <a style="color: rgb(208, 206, 206); letter-spacing: 3px;" href="/Home/Home.html"><span
                                class="Auto" style="color: red; ">Auto</span>Drive</a>
                        <p>AutoMaster Parts Co., Ltd.</p>
                    </div>
                    <div class="auto-1">
                        <p>Committed to delivering comprehensive auto parts <br> solutions for enthusiasts and
                            everyday drivers, <br> enhancing safety and convenience.</p>
                    </div>
                    <div class="auto-1 hover-item"><a href="#">Btecfpt@gmail.com</a></div>
                </div>

                <div class="footer-item-end ovelay"></div>

                <div class="footer-item-end">
                    <h2>Need Help?</h2>
                    <div class="auto-1 hover-item">
                        <a href="#">(84+) 559-997-776</a>
                    </div>
                    <div class="auto-1">
                        <p>Monday to Friday<span> </span>9AM - 5PM <br>Saturday & Sunday only 10AM to 12PM.</p>
                    </div>
                    <div class="auto-1 hover-item">
                        <a href="#">Btecfpt@gmail.com</a>
                    </div>
                </div>

                <div class="footer-item-end menu-item">
                    <h2>Pages</h2>
                    <ul>
                        <li><a href="/Home/Home.html">Home</a></li>
                        <li><a href="/Shop/Shop.html">Shop</a></li>
                        <li><a href="/News/News.html">Blogs</a></li>
                        <li><a href="/Contact/Contact.html">Contact</a></li>
                    </ul>
                </div>

                <div class="footer-item-end menu-item">
                    <h2>Social</h2>
                    <ul>
                        <li><a href="#">Instagram</a></li>
                        <li><a href="#">Facebook</a></li>
                        <li><a href="#">Twitter</a></li>
                        <li><a href="#">YouTube</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-item-2">
                <p style="letter-spacing: 1px;">&copy; 2024 <span class="Auto" style="color: red; ">Auto</span>Drive</p>
                <p>Designed by MrQuocAnh. Powered by Teacher Hanh.</p>
            </div>
        </div>
    </div>
</body>
</html>

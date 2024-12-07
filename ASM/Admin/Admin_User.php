<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/ASM/Admin/AdminConner.php');

// Lấy danh sách người dùng từ cơ sở dữ liệu
$sql = "SELECT user_id, email, fullname, password FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="../Admin/Admin_user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!-- Header -->
    <div class="Container-Admin">
        <div id="Header-Container">

            <!-- Header Nav -->
            <div id="Header-Nav">
                <div class="Header-logo">
                    <a href="/Home/Home.html"><span class="Auto" style="color: red;">Auto</span>Drive</a>
                </div>
                <!-- Header Menu -->
                <div class="Header-menu">
                    <ul class="Header-ul">
                        <li><a href="../Admin/Admin.php">Admin</a></li>
                    </ul>
                </div>

                <!-- Header Icon -->
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

        <div class="col-layout">
            <h1>INTERFACE</h1>
            <div class="layout"></div>
            <ul class="nav-flex-column">
                <li class="nav-item">
                    <a class="nav-link text-white toggle-link" href="#"> Pages</a>
                    <ul class="submenu">
                        <li><a class="nav-link text-white" href="http://localhost/ASM/Admin/Admin.php">Shop</a></li>
                    </ul>
                </li>
            </ul>


            <ul class="nav-flex-column">
                <li class="nav-item-1">
                    <a class="nav-link text-white toggle-link" href="#"> Table </a>
                    <ul class="submenu">
                        <li><a class="nav-link text-white" href="../Admin/Product.php">products</a></li>
                        <li><a class="nav-link text-white" href="../Admin/Admin_User.php">users</a></li>
                    </ul>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <h2>User Account Management</h2>

            <!-- Hiển thị thông báo -->
            <?php
            if (isset($_GET['message'])) {
                $message = $_GET['message'];
                if ($message == 'success') {
                    echo "<p style='color: green;'>User deleted successfully!</p>";
                } elseif ($message == 'error') {
                    echo "<p style='color: red;'>Error deleting user. Please try again.</p>";
                } elseif ($message == 'invalid') {
                    echo "<p style='color: orange;'>Invalid user ID.</p>";
                }
            }
            ?>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Fullname</th>
                            <th>Password</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            // Hiển thị các hàng trong bảng
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['user_id'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td>" . $row['fullname'] . "</td>";
                                echo "<td>" . $row['password'] . "</td>";
                                echo "<td><a href='../Admin/Product.Admin/DeleteUser.php?id=" . $row["user_id"] . "' class='delete-btn'>Delete</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No users found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<script src="../Admin/Admin.js"></script>

</html>

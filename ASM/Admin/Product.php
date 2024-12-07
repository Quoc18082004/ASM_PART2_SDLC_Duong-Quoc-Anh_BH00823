<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/ASM/Admin/Product.Admin/Product.Admin.css?v=<?php echo time(); ?>">
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
                    <a href="/Home/Home.html"><span class="Auto" style="color: red; ">Auto</span>Drive</a>
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
                        <li><a class="nav-link text-white" href="http://localhost/ASM/Admin/Admin.php#">Shop</a></li>
                    </ul>
                </li>
            </ul>

            <ul class="nav-flex-column">
                <li class="nav-item-1">
                    <a class="nav-link text-white toggle-link" href="#"> Table </a>
                    <ul class="submenu">
                        <li><a class="nav-link text-white" href="http://localhost/ASM/Admin/Product.php">products</a></li>
                        <li><a class="nav-link text-white" href="http://localhost/ASM/Admin/Admin_User.php">users</a></li>
                    </ul>
                </li>
            </ul>

        </div>

        <!-- Main Content -->
        <div class="main-content">
            <h2>Products Management</h2>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Image URL</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    // Include file kết nối MySQL
                    require($_SERVER['DOCUMENT_ROOT'] . '/ASM/Admin/AdminConner.php');

                    // Truy vấn dữ liệu
                    $sql = "SELECT product_id, product_name, description, price, quantity, image_url, created_at FROM products";
                    $result = $conn->query($sql);

                    // Hiển thị dữ liệu
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Kiểm tra và làm sạch giá trị price
                            if (!empty($row["price"])) {
                                $clean_price = floatval(preg_replace('/[^\d.]/', '', $row["price"]));
                            } else {
                                $clean_price = 0.00; // Giá trị mặc định nếu không có giá
                            }

                            echo "<tr>";
                            echo "<td>" . $row["product_id"] . "</td>";
                            echo "<td>" . $row["product_name"] . "</td>";
                            echo "<td>" . $row["description"] . "</td>";
                            echo "<td>" . "$ " . number_format($clean_price, 2) . " USD" . "</td>";
                            echo "<td>" . $row["quantity"] . "</td>";
                            echo "<td><img src='" . $row["image_url"] . "' alt='Product Image' style='width: 100px; height: auto;'></td>";
                            echo "<td>" . $row["created_at"] . "</td>";
                            echo "<td>
                                <a href='../Admin/Product.Admin/editProduct.php?id=" . $row["product_id"] . "' class='edit-btn'>Edit</a>
                                <a href='../Admin/Product.Admin/DeleteProduct.php?id=" . $row["product_id"] . "' class='delete-btn'>Delete</a>
                              </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No products found</td></tr>";
                    }

                    // Đóng kết nối
                    $conn->close();
                    ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
<script src="../Admin/Admin.js"></script>

</html>

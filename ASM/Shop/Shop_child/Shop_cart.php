<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nhận dữ liệu từ form
    $product_id = $_POST['product_id'] ?? '';
    $product_name = $_POST['product_name'] ?? '';
    $product_price = $_POST['product_price'] ?? 0; // Đặt mặc định là 0 nếu không có giá trị
    $quantity = $_POST['quantity'] ?? 1;

    // Kiểm tra giá trị bắt buộc
    if (empty($product_id) || empty($product_name) || $product_price === 0) {
        die('Error: Missing product data. Please check the form submission.');
    }

    // Khởi tạo giỏ hàng nếu chưa có
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Kiểm tra sản phẩm trong giỏ hàng
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['product_id'] === $product_id) {
            $item['quantity'] += $quantity;
            $found = true;
            break;
        }
    }

    // Thêm sản phẩm mới vào giỏ hàng
    if (!$found) {
        $_SESSION['cart'][] = [
            'product_id' => $product_id,
            'product_name' => $product_name,
            'product_price' => $product_price,
            'quantity' => $quantity,
        ];
    }
    echo 'Thank you for your purchase';
    // Chuyển hướng về trang giỏ hàng
    header('Location: /ASM/Shop/Shop_child/shop_cart.php');
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/ASM/Shop/Shop_child/Shop.cart.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css">
</head>

<body>
    <!-- Header -->
    <div id="Header-Container">

        <!-- Header Nav -->
        <div id="Header-Nav">
            <div class="Header-logo">
                <a href="/Home/Home.html"><span class="Auto" style="color: red; ">Auto</span>Drive</a>
            </div>

            <!-- Header Menu -->
            <div class="Header-menu">
                <ul class="Header-ul">
                    <li><a href="http://localhost/ASM/Shop/Shop_child/Shop_1.php">Shop</a></li>

                </ul>
            </div>

            <!-- Header Icon -->
            <div class="Header-icon">
                <div class="Header-item">
                    <a href="http://localhost/ASM/Login/login.php"><i class="fa-regular fa-user"></i> Login</a>
                </div>
                <div class="divider"> </div>
                <div class="Header-item">
                    <a href="http://localhost/ASM/Shop/Shop_child/shop_cart.php"><i
                            class="fa-solid fa-cart-shopping"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div id="cartModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Your Cart</h2>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <div class="modal-body" id="cartItems">
                <p>No items found.</p>
            </div>
            <div class="modal-footer">
                <button class="checkout-button" onclick="alert('Proceeding to checkout')">Continue to Checkout</button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h2>Shop Cart</h2>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Quantity</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                        <?php foreach ($_SESSION['cart'] as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                <td>$<?php echo number_format($item['product_price'], 2); ?></td>
                                <td>$<?php echo number_format($item['quantity'] * $item['product_price'], 2); ?></td>
                                <td>
                                    <form action="/ASM/Shop/Shop_child/remove_item.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">Your cart is empty.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
            <div class="layout">
                <div class="back-to-shop">
                    <a href="/ASM/Shop/Shop_child/Shop_1.php" class="btn-back">← Back to Shop</a>
                </div>

                <div class="order-button-container">
                    <form action="place_order.php" method="POST">
                        <button type="submit" class="btn-order">Place Order</button>
                    </form>
                </div>
            </div>

        </div>
    </div>


    <!-- footer -->

    <div id="Footer">
        <div class="footer-item">
            <div class="footer-item-1">
                <div class="footer-item-end">
                    <div class="AutoMaster ">
                        <a style="color: rgb(208, 206, 206); letter-spacing: 3px;" href="/Home/Home.html"><span
                                class="Auto" style="color: red; ">Auto</span>Drive</a>
                        <p>AutoMaster Parts Co., Ltd.</p>
                    </div>
                    <div class="auto-1">
                        <p>Committed to delivering comprehensive auto parts <br> solutions for enthusiasts and everyday
                            drivers, <br> enhancing safety and convenience.</p>
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
                        <li><a href="#">Shop</a></li>
                        <li><a href="#">Our Story</a></li>
                        <li><a href="#">Collection</a></li>
                        <li><a href="#">Blogs</a></li>
                        <li><a href="#">Review</a></li>
                        <li><a href="#">Contact</a></li>
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
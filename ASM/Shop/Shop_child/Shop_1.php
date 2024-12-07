<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receive data from the form
    $product_id = $_POST['product_id'] ?? '';
    $product_name = $_POST['product_name'] ?? '';
    $product_price = $_POST['product_price'] ?? 0; // Default to 0 if no value is provided
    $quantity = $_POST['quantity'] ?? 1;

    // Check required fields
    if (empty($product_id) || empty($product_name) || $product_price === 0) {
        die('Error: Missing product data. Please check the form submission.');
    }

    // Initialize cart if it does not exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if the product is already in the cart
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['product_id'] === $product_id) {
            $item['quantity'] += $quantity;
            $found = true;
            break;
        }
    }

    // Add new product to cart
    if (!$found) {
        $_SESSION['cart'][] = [
            'product_id' => $product_id,
            'product_name' => $product_name,
            'product_price' => $product_price,
            'quantity' => $quantity,
        ];
    }
    echo 'Thank you for your purchase';
    // Redirect to cart page
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
    <link rel="stylesheet" href="/ASM/Shop/Shop_child/Shop_1.css?v=<?php echo time(); ?>">
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
                <a href="http://localhost/ASM/Shop/Shop_child/Shop_1.php"><span class="Auto" style="color: red; ">Auto</span>Drive</a>
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
                    <a href="http://localhost/ASM/Shop/Shop_child/shop_cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="products-grid">
        <?php
        // Include MySQL connection file
        require($_SERVER['DOCUMENT_ROOT'] . '/ASM/Admin/AdminConner.php');

        // Query data
        $sql = "SELECT product_id, product_name, description, price, quantity, image_url, created_at FROM products";
        $result = $conn->query($sql);

        // Display data
        if ($result->num_rows > 0) {
            echo "<div class='product-row'>"; // Use flex/grid for horizontal layout
            while ($row = $result->fetch_assoc()) {
                echo "<div class='Product-col'>"; // Use Product-col class
                echo "  <div class='img-product'>";
                echo "      <img src='" . $row["image_url"] . "' alt='Product Image'>"; // Product image
                echo "  </div>";
                echo "  <div class='name-product'>";
                echo "      <span>" . $row["product_name"] . "</span>"; // Product name
                echo "      <p>$ " . number_format($row["price"], 2) . " USD</p>"; // Product price
                echo "  </div>";
                echo "  <div class='quantity-control'>";
                echo "      <input type='number' class='quantity-input' value='1' min='1' max='" . $row["quantity"] . "'>";
                echo "  </div>";
                echo "  <button class='add-to-cart' onclick='addToCart(" . $row["product_id"] . ", \"" . $row["product_name"] . "\", " . $row["price"] . ", this)'>Add to Cart</button>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<div class='no-products'>No products found</div>"; // When no products are available
        }

        // Close connection
        $conn->close();
        ?>
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
                <button class="checkout-button" onclick="alert('Proceeding to checkout')">Continue to
                    Checkout</button>
                    <button class='add-to-cart' onclick='addToCart(" . $row["product_id"] . ", \"" . $row["product_name"] . "\", " . $row["price"] . ", this)'>Add to Cart</button>";
            </div>
        </div>
    </div>

    <!-- Footer -->
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

<script>
 function addToCart(productId, productName, productPrice, buttonElement) {
    // Get the quantity from the nearest input
    const quantityInput = buttonElement.closest('.Product-col').querySelector('.quantity-input');
    const quantity = quantityInput ? quantityInput.value : 1;

    // Create a dynamic form to send the data
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/ASM/Shop/Shop_child/shop_cart.php';

    // Add product data to the form
    const fields = [
        { name: 'product_id', value: productId },
        { name: 'product_name', value: productName },
        { name: 'product_price', value: productPrice },
        { name: 'quantity', value: quantity }
    ];

    fields.forEach(field => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = field.name;
        input.value = field.value;
        form.appendChild(input);
    });

    // Append the form to the body and submit it
    document.body.appendChild(form);
    form.submit();
}
</script>

</html>

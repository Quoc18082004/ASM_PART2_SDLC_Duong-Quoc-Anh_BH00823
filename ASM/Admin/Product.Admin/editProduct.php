<?php
require($_SERVER['DOCUMENT_ROOT'] . '/ASM/Admin/AdminConner.php');

// Check if the user has sent a POST request to save the edits
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];

    // Get the price value and remove any non-numeric characters or separators
    $price = preg_replace("/[^0-9.]/", "", $_POST['price']); // Remove non-numeric characters and period
    $quantity = $_POST['quantity'];
    $image_url = $_POST['image_url'];
    $created_at = $_POST['created_at'];

    // Validate the fields
    if (!empty($product_name) && !empty($description) && !empty($price) && !empty($quantity) && !empty($image_url) && !empty($created_at)) {
        // UPDATE SQL query
        $sql = "UPDATE products SET product_name = ?, description = ?, price = ?, quantity = ?, image_url = ?, created_at = ? WHERE product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdissi", $product_name, $description, $price, $quantity, $image_url, $created_at, $product_id);

        if ($stmt->execute()) {
            echo "Product updated successfully!";
            header('Location: Product.php?page_layout=danhsach');
            exit();
        } else {
            echo "Error updating product: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Please enter all the required information.";
    }
}

// Fetch the current product information to display on the form
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();
} else {
    echo "Product not found!";
    exit();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../Admin.css">
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
                        <li><a href="../Home.Admin/Home.php">Home</a></li>
                        <li><a href="../Shop.Admin/Shop.php">Shop</a></li>
                        <li><a href="../Admin/Admin.php">Admin</a></li>
                    </ul>
                </div>

                <!-- Header Icon -->
                <div class="Header-icon">
                    <div class="Header-item">
                        <a href="/Login/login.html"><i class="fa-regular fa-user"></i> Login</a>
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
                        <li><a class="nav-link text-white" href="#">Shop</a></li>
                        <li><a class="nav-link text-white" href="#">User Account</a></li>
                    </ul>
                </li>
            </ul>

            <ul class="nav-flex-column">
                <li class="nav-item-1">
                    <a class="nav-link text-white toggle-link" href="#"> Table </a>
                    <ul class="submenu">
                        <li><a class="nav-link text-white" href="#">categories</a></li>
                        <li><a class="nav-link text-white" href="#">orders</a></li>
                        <li><a class="nav-link text-white" href="#">order_details</a></li>
                        <li><a class="nav-link text-white" href="../Admin/Product.Admin/Product.php">products</a></li>
                        <li><a class="nav-link text-white" href="#">reviews</a></li>
                        <li><a class="nav-link text-white" href="#">users</a></li>
                    </ul>
                </li>
            </ul>
        </div>

        <form method="POST" action="editProduct.php" class="Container-2">
            <h1>Edit Product</h1>
            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">

            <div class="items-input">
                <label for="product_name">Product Name</label>
                <input type="text" name="product_name" id="product_name"
                    value="<?php echo htmlspecialchars($product['product_name']); ?>" maxlength="255" required>
            </div>

            <div class="items-input">
                <label for="description">Description</label>
                <textarea name="description" id="description" rows="4"
                    required><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>

            <div class="items-input">
                <label for="price">Price</label>
                <input type="text" name="price" id="price" value="<?php echo number_format($product['price'], 2, '.', ','); ?> USD"
                    required>
            </div>

            <div class="items-input">
                <label for="quantity">Stock Quantity</label>
                <input type="number" name="quantity" id="quantity" value="<?php echo $product['quantity']; ?>" required>
            </div>

            <div class="items-input">
                <label for="image_url">Image URL</label>
                <input type="url" name="image_url" id="image_url"
                    value="<?php echo htmlspecialchars($product['image_url']); ?>" maxlength="255" required>
            </div>

            <div class="items-input">
                <label for="created_at">Creation Date</label>
                <input type="datetime-local" name="created_at" id="created_at"
                    value="<?php echo date('Y-m-d\TH:i', strtotime($product['created_at'])); ?>" required>
            </div>

            <button type="submit">Update Product</button>
        </form>

    </div>

</body>
<script src="../Admin/Admin.js"></script>

</html>

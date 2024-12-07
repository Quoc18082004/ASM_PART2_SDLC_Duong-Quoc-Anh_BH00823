<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="/ASM/Admin/Admin.css?v=<?php echo time(); ?>">
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
                        <a href="../Login/login.php"><i class="fa-regular fa-user"></i> Login</a>
                    </div>

                    <div class="divider"></div>
                    <div class="Header-item">
                        <a href="http://localhost/ASM/Shop/Shop_child/shop_cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
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

        <form method="POST" action="root.php" class="Container-2">

            <h1>Admin Privilege: Shop</h1>
            <div class="items-input">
                <input type="hidden" name="category_id" value="1">
            </div>
            <div class="items-input">
                <label for="product_name">Product Name</label>
                <input type="text" name="product_name" id="product_name" maxlength="255" required>
            </div>
            <div class="items-input">
                <label for="description">Description</label>
                <textarea name="description" id="description" rows="4" required></textarea>
            </div>
            <div class="items-input">
                <label for="price">Price</label>
                <input type="text" name="price" id="price" step="0.01" required>
            </div>
            <div class="items-input">
                <label for="quantity">Stock Quantity</label>
                <input type="number" name="quantity" id="quantity" required>
            </div>
            <div class="items-input">
                <label for="image_url">Image URL</label>
                <input type="url" name="image_url" id="image_url" maxlength="255" required>
            </div>
            <div class="items-input">
                <label for="created_at">Created At</label>
                <input type="datetime-local" name="created_at" id="created_at" required>
            </div>
            <div class="items-input">
                <label>Category ID:</label>
                <input type="text" name="category_id" required><br>
            </div>
            <div class="items-input">
                <label>Category Name:</label>
                <input type="text" name="category_name" required><br>
            </div>
            <button type="submit" name="dangnhap">Insert Product</button>
        </form>

    </div>

    </div>
</body>
<script src="../Admin/Admin.js"></script>

</html>
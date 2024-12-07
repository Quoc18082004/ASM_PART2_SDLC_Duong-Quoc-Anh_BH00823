<?php
require($_SERVER['DOCUMENT_ROOT'] . '/ASM/Admin/AdminConner.php');

// Kiểm tra xem người dùng có gửi yêu cầu POST để lưu chỉnh sửa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];

    // Lấy giá trị giá và loại bỏ ký tự không phải số hoặc dấu phân cách
    $price = preg_replace("/[^0-9.]/", "", $_POST['price']); // Loại bỏ ký tự không phải số và dấu chấm
    $quantity = $_POST['quantity'];
    $image_url = $_POST['image_url'];
    $created_at = $_POST['created_at'];

    // Kiểm tra các trường dữ liệu
    if (!empty($product_name) && !empty($description) && !empty($price) && !empty($quantity) && !empty($image_url) && !empty($created_at)) {
        // Câu lệnh UPDATE
        $sql = "UPDATE products SET product_name = ?, description = ?, price = ?, quantity = ?, image_url = ?, created_at = ? WHERE product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdissi", $product_name, $description, $price, $quantity, $image_url, $created_at, $product_id);

        if ($stmt->execute()) {
            echo "Cập nhật sản phẩm thành công!";
            header('Location: Product.php?page_layout=danhsach');
            exit();
        } else {
            echo "Lỗi khi cập nhật sản phẩm: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Vui lòng nhập đầy đủ thông tin.";
    }
}

// Lấy thông tin sản phẩm hiện tại để hiển thị lên form
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
    echo "Không tìm thấy sản phẩm!";
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
                    <a href="/Home/Home.html"><span class="Auto" style="color: red; ">Auto</span>Drive</a>
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
            <h1>Chỉnh sửa sản phẩm</h1>
            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">

            <div class="items-input">
                <label for="product_name">Tên sản phẩm</label>
                <input type="text" name="product_name" id="product_name"
                    value="<?php echo htmlspecialchars($product['product_name']); ?>" maxlength="255" required>
            </div>

            <div class="items-input">
                <label for="description">Mô tả</label>
                <textarea name="description" id="description" rows="4"
                    required><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>

            <div class="items-input">
                <label for="price">Giá</label>
                <input type="text" name="price" id="price" value="<?php echo number_format($product['price'], 2, '.', ','); ?> USD"
                    required>
            </div>

            <div class="items-input">
                <label for="quantity">Số lượng tồn kho</label>
                <input type="number" name="quantity" id="quantity" value="<?php echo $product['quantity']; ?>" required>
            </div>

            <div class="items-input">
                <label for="image_url">URL Hình ảnh</label>
                <input type="url" name="image_url" id="image_url"
                    value="<?php echo htmlspecialchars($product['image_url']); ?>" maxlength="255" required>
            </div>

            <div class="items-input">
                <label for="created_at">Ngày tạo</label>
                <input type="datetime-local" name="created_at" id="created_at"
                    value="<?php echo date('Y-m-d\TH:i', strtotime($product['created_at'])); ?>" required>
            </div>

            <button type="submit">Cập nhật sản phẩm</button>
        </form>

    </div>

</body>
<script src="../Admin/Admin.js"></script>

</html>

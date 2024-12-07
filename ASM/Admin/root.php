<?php

require($_SERVER['DOCUMENT_ROOT'] . '/ASM/Admin/AdminConner.php');

if (isset($_POST['category_id'])) {
    echo '<pre>';
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $image_url = $_POST['image_url'];
    $created_at = $_POST['created_at'];

    // Thông tin bảng categories
    $category_id = $_POST['category_id']; 
    $category_name = $_POST['category_name'];

    // Kiểm tra dữ liệu đầu vào
    if (!empty($product_name) && !empty($description) && !empty($price) && !empty($quantity) && 
        !empty($image_url) && !empty($created_at) && !empty($category_id) && !empty($category_name)) {

        echo '<pre>';
        print_r($_POST);

        // Chèn vào bảng products
        $sql_product = "INSERT INTO `products` (`product_name`, `description`, `price`, `quantity`, `image_url`, `created_at`) 
                        VALUES('$product_name', '$description', '$price', '$quantity', '$image_url', '$created_at')";
        
        // Kiểm tra nếu `category_id` đã tồn tại trong bảng `categories`
        $check_category = "SELECT * FROM `categories` WHERE `category_id` = '$category_id'";
        $result = $conn->query($check_category);

        if ($result->num_rows > 0) {
            // Nếu tồn tại, cập nhật thông tin
            $sql_category = "UPDATE `categories` 
                             SET `category_name` = '$category_name', `description` = '$description', `created_at` = '$created_at' 
                             WHERE `category_id` = '$category_id'";
        } else {
            // Nếu không tồn tại, thêm mới
            $sql_category = "INSERT INTO `categories` (`category_id`, `category_name`, `description`, `created_at`) 
                             VALUES('$category_id', '$category_name', '$description', '$created_at')";
        }

        // Thực hiện các câu lệnh SQL
        if ($conn->query($sql_product) === TRUE && $conn->query($sql_category) === TRUE) {
            echo "Lưu dữ liệu thành công vào cả bảng products và categories";
            header('Location: http://localhost/ASM/Admin/Product.php#?page_layout=danhsach');
        } else {
            echo "Lỗi khi lưu dữ liệu: <br> {$sql_product} <br> {$sql_category} <br>" . $conn->error;
        }
        
    } else {
        echo "Bạn cần nhập đầy đủ thông tin";
    }
}

?>

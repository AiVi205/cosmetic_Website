<?php
session_start();

// Kiểm tra xem giỏ hàng có sản phẩm không
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Kiểm tra nếu có tham số MaSP trong URL
if (isset($_GET['MaSP'])) {
    $product_id = $_GET['MaSP'];

    // Tìm và xóa sản phẩm trong giỏ hàng
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['MaSP'] === $product_id) {
            unset($_SESSION['cart'][$key]); // Xóa sản phẩm
            break; // Dừng vòng lặp khi đã tìm thấy sản phẩm
        }
    }
}

// Chuyển hướng về trang giỏ hàng
header("Location: cart.php");
exit();
?>

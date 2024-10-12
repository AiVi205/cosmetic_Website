<?php
session_start();
include '../inc/database.php'; // Đảm bảo đường dẫn đúng

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['MaND'])) {
    echo "Bạn cần đăng nhập để xóa sản phẩm.";
    exit();
}

// Kiểm tra nếu có sản phẩm để xóa
if (isset($_GET['MaSP'])) {
    $MaSP = $_GET['MaSP'];
    $MaND = $_SESSION['MaND'];

    // Giảm số lượng sản phẩm
    $check_sql = "SELECT SoLuong FROM giohang WHERE MaSP = $MaSP AND MaND = $MaND";
    $check_result = mysqli_query($conn, $check_sql);
    $row = mysqli_fetch_assoc($check_result);
    
    if ($row) {
        $new_quantity = $row['SoLuong'] - 1;

        if ($new_quantity > 0) {
            // Cập nhật số lượng nếu còn lại
            $update_sql = "UPDATE giohang SET SoLuong = $new_quantity WHERE MaSP = $MaSP AND MaND = $MaND";
            mysqli_query($conn, $update_sql);

            // Cập nhật giỏ hàng trong session
            $_SESSION['cart'][$MaSP] = $new_quantity; // Cập nhật số lượng trong session
        } else {
            // Xóa sản phẩm nếu số lượng bằng 0
            $delete_sql = "DELETE FROM giohang WHERE MaSP = $MaSP AND MaND = $MaND";
            mysqli_query($conn, $delete_sql);

            // Xóa khỏi giỏ hàng trong session
            unset($_SESSION['cart'][$MaSP]); // Xóa sản phẩm khỏi session
        }
    }

    // Chuyển hướng về trang giỏ hàng
    header("Location: cart.php");
    exit();
} 
?>

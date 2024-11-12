<?php
session_start();
include "../inc/database.php";

// Kiểm tra xem người dùng đã đăng nhập chưa
if (isset($_SESSION['MaND'])) {
    $user_id = $_SESSION['MaND'];
    $product_id = $_POST['MaSP'];
    $quantity = $_POST['SoLuong'];
    $Price = $_POST['Gia'];

    // Kiểm tra xem sản phẩm đã có trong giỏ hàng của người dùng chưa
    $sql = "SELECT * FROM giohang WHERE MaND = ? AND MaSP = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Nếu sản phẩm đã tồn tại trong giỏ hàng, tăng số lượng
        $sql = "UPDATE giohang SET SoLuong = SoLuong + ? WHERE MaND = ? AND MaSP = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $quantity, $user_id, $product_id);
    } else {
        // Nếu sản phẩm chưa tồn tại, thêm mới vào giỏ hàng
        $sql = "INSERT INTO giohang (MaND, MaSP, SoLuong, Tongtien) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiii", $user_id, $product_id, $quantity, $Price);
    }
    $stmt->execute();
    $stmt->close();
} else {
    // Nếu người dùng chưa đăng nhập, lưu giỏ hàng vào session
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    $product_id = $_POST['MaSP'];
    $quantity = $_POST['SoLuong'];
    $Price = $_POST['Gia'];  // You need to fetch the price for guest carts

    // Kiểm tra sản phẩm đã có trong giỏ hàng hay chưa
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['SoLuong'] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = array(
            'MaSp' => $product_id,
            'SoLuong' => $quantity,
            'Gia' => $Price  // Add the price to the session for non-logged-in users
        );
    }
    // Không cần đóng statement ở đây vì không có statement cho khách
}

// Redirect to cart page after adding to cart
header("Location: cart.php");
exit();
?>

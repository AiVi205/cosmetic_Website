
<?php
session_start();

// Kết nối đến cơ sở dữ liệu
include "../inc/database.php";

// Lấy mã sản phẩm và số lượng từ form
$product_id = $_POST['MaSP'];
$product_quantity = isset($_POST['SoLuong']) ? (int)$_POST['SoLuong'] : 1;  // Mặc định số lượng là 1 nếu không có số lượng được nhập

// Truy vấn chi tiết sản phẩm từ cơ sở dữ liệu
$sql = "SELECT MaSP, TenSP, DonGiaNhap, GiaUuDai FROM sanpham WHERE MaSP = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $product_id);  // "s" đại diện cho chuỗi
$stmt->execute();
$result = $stmt->get_result();

// Kiểm tra nếu tìm thấy sản phẩm
if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();  // Lấy dữ liệu sản phẩm dưới dạng mảng liên kết

    // Kiểm tra nếu có giá ưu đãi, nếu có thì dùng, nếu không thì dùng DonGiaNhap
    if (!is_null($product['GiaUuDai']) && $product['GiaUuDai'] > 0) {
        $product['DonGiaNhap'] = $product['GiaUuDai'];
    } else {
        $product['donGiaNhap'] = $product['DonGiaNhap'];
    }

    // Thêm số lượng sản phẩm vào thông tin sản phẩm
    $product['SoLuong'] = $product_quantity;

    // Kiểm tra nếu giỏ hàng chưa được tạo
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Kiểm tra nếu sản phẩm đã tồn tại trong giỏ hàng
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['MaSP'] == $product['MaSP']) {
            // Nếu sản phẩm đã tồn tại, tăng số lượng
            $item['SoLuong'] += $product_quantity;
            $found = true;
            break;
        }
    }

    // Nếu sản phẩm chưa có trong giỏ hàng, thêm vào
    if (!$found) {
        $_SESSION['cart'][] = $product;
    }
    // Chuyển hướng về trang giỏ hàng
    header("Location: cart.php");
    exit();

} else {
    echo "Không tìm thấy sản phẩm.";
}

// Đóng kết nối cơ sở dữ liệu
$stmt->close();
$conn->close();


?>

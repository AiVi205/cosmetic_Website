<?php
session_start();
include "../inc/database.php";
$shipping_fee = 30000;

// Kiểm tra xem form có được submit không
if (isset($_POST['submit_order'])) {
    // Lấy thông tin đơn hàng từ form
    $hoten = $_POST['ho_ten'];
    $email = $_POST['email'];
    $sdt = $_POST['sdt'];
    $diachi = $_POST['diachi'];
    $payment = $_POST['payment'];

    // Tính tổng tiền sản phẩm
    $total_price = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $product_id => $product) {
            $total_price += $product['SoLuong'] * $product['Gia'];
        }
    }

    // Phí vận chuyển (nếu có)
    $total_amount = $total_price + $shipping_fee;

    // Lấy mã người dùng nếu người dùng đã đăng nhập
    $user_id = isset($_SESSION['MaND']) ? $_SESSION['MaND'] : null;

    // Thêm thông tin đơn hàng vào bảng `donhang` với thời gian hiện tại bằng cách sử dụng NOW()
    $sql = "INSERT INTO donhang (MaND, HoTen, Email, SDT, DiaChi, Payment_Method, TongTien, NgayDH) 
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssid", $user_id, $hoten, $email, $sdt, $diachi, $payment, $total_amount);
    $stmt->execute();
    $order_id = $stmt->insert_id;
    $stmt->close();

    // Lấy danh sách sản phẩm từ giỏ hàng để lưu chi tiết đơn hàng vào bảng `ctdh`
    // foreach ($_SESSION['cart'] as $product_id => $product) {
    //     $so_luong = $product['SoLuong'];
    //     $gia = $product['Gia'];
        
    //     // Thêm chi tiết sản phẩm vào bảng `ctdh`, kèm theo phương thức thanh toán
    //     $sql = "INSERT INTO ctdh (MaDH, MaSP, SoLuong, Gia) VALUES (?, ?, ?, ?)";
    //     $stmt = $conn->prepare($sql);
    //     $stmt->bind_param("iiid", $order_id, $product_id, $so_luong, $gia, $payment);
    //     $stmt->execute();
    // }

    // Xóa sản phẩm trong giỏ hàng của người dùng (nếu đã đăng nhập và giỏ hàng lưu trong cơ sở dữ liệu)
    if (isset($user_id)) {
        $sql = "DELETE FROM giohang WHERE MaND = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
    }

    // Xóa giỏ hàng khỏi session
    unset($_SESSION['cart']);

    // Thông báo và chuyển hướng
    echo "<script>alert('Đặt hàng thành công!'); window.location.href='place_order.php';</script>";
}
?>

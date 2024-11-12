<?php
session_start();
include "../inc/database.php";
// Khởi tạo các biến để tính tổng tiền và phí vận chuyển
$total_price = 0;
$shipping_fee = 30000; // Phí vận chuyển cố định
$products = []; // Mảng lưu các sản phẩm trong giỏ hàng

// Lấy sản phẩm trong giỏ hàng
// Lấy sản phẩm trong giỏ hàng
if (isset($_SESSION['MaND'])) {
    // Người dùng đã đăng nhập, lấy giỏ hàng từ cơ sở dữ liệu
    $user_id = $_SESSION['MaND'];

    // Truy vấn để lấy thông tin người dùng
    $sql_user = "SELECT HoTen FROM nguoidung WHERE MaND = ?";
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->bind_param("i", $user_id);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();
    $user_info = $result_user->fetch_assoc();
    $stmt_user->close();

    // Lấy giỏ hàng từ cơ sở dữ liệu
    $sql = "SELECT c.*, p.TenSP, p.GiaUuDai, p.DonGiaNhap FROM giohang c 
            JOIN sanpham p ON c.MaSP = p.MaSP 
            WHERE c.MaND = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $price = $row['GiaUuDai'] ?? $row['DonGiaNhap'];
        $row['Gia'] = $price;
        $row['ThanhTien'] = $row['SoLuong'] * $price;
        $total_price += $row['ThanhTien'];
        $products[] = $row;
    }
    $stmt->close();
} else {
    // Người dùng chưa đăng nhập, lấy giỏ hàng từ session
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $product_id => $details) {
            $sql = "SELECT * FROM sanpham WHERE MaSP = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $product = $result->fetch_assoc();

            if ($product) {
                $product['Gia'] = $product['GiaUuDai'] ?? $product['DonGiaNhap'];
                $product['SoLuong'] = $details['SoLuong'];
                $product['ThanhTien'] = $product['SoLuong'] * $product['Gia'];
                $total_price += $product['ThanhTien'];
                $products[] = $product;
            }
        }
    }
}

// Tính tổng tiền thanh toán bao gồm phí vận chuyển
$total_amount = $total_price + $shipping_fee;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Thanh toán</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="../Accountcss/style.css" rel="stylesheet">
</head>

<body>
    <!-- Include header -->
    <?php include "../inc/header.php" ?>

    <!-- Checkout Form -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-7">
                <h5 class="section-title text-uppercase mb-3">Địa chỉ thanh toán</h5>
                <div class="bg-light p-30 mb-5">
                    <form action="place_order.php" method="POST">
                        <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Họ Tên</label>
                            <input class="form-control" type="text" name="ho_ten" value="<?php echo htmlspecialchars($user_info['HoTen']); ?>" required>
                        </div>

                            <div class="col-md-6 form-group">
                                <label>Email</label>
                                <input class="form-control" type="email" name="email" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Số điện thoại</label>
                                <input class="form-control" type="text" name="sdt" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Địa chỉ</label>
                                <input class="form-control" type="text" name="diachi" required>
                            </div>
                        </div>
                        <h5 class="text-uppercase mb-3">Phương thức thanh toán</h5>
                            <div class="bg-light p-30 mb-3">
                                <div class="form-group">
                                    <input type="radio" id="momo" name="payment" value="momo" required>
                                    <label for="momo">Thanh toán trước qua MoMo</label>
                                </div>
                                <div class="form-group">
                                    <input type="radio" id="direct" name="payment" value="direct" required>
                                    <label for="direct">Thanh toán trực tiếp</label>
                                </div>
                            </div>

                        <button type="submit" name="submit_order" class="btn btn-primary btn-block">Đặt hàng</button>
                    </form>
                </div>
            </div>

            <!-- Phần tóm tắt đơn hàng -->
            <div class="col-lg-5">
                <h5 class="section-title text-uppercase mb-3">Tổng thanh toán</h5>
                <div class="bg-light p-30">
                    <div class="border-bottom">
                        <h6 class="mb-3">Sản phẩm</h6>
                        <?php if (!empty($products)) : ?>
                            <?php foreach ($products as $product): ?>
                                <div class="d-flex justify-content-between">
                                    <p><?php echo htmlspecialchars($product['TenSP']);?> (x<?php echo $product['SoLuong']; ?>)</p>
                                    <p><?php echo number_format($product['Gia'], 0); ?> VND</p>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p>Giỏ hàng trống.</p>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <h6>Tổng sản phẩm</h6>
                        <p><?php echo number_format($total_price, 0); ?> VND</p>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <h6>Phí vận chuyển</h6>
                        <p><?php echo number_format($shipping_fee, 0); ?> VND</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6>Tổng thanh toán</h6>
                        <h6><?php echo number_format($total_amount, 0); ?> VND</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include footer -->
    <?php include "../inc/footer.php" ?>
</body>
</html>

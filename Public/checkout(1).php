<?php
session_start();
include '../inc/database.php';

// Bắt đầu kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

// Khai báo biến để tính tổng giá
$total_price = 0;
$shipping_fee = 10; // Phí vận chuyển cố định
$products = [];

// Kiểm tra và hiển thị nội dung giỏ hàng
echo '<pre>';
print_r($_SESSION['cart']);
echo '</pre>';

// Lấy thông tin giỏ hàng từ session
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $product_id => $item) {
        // Lấy thông tin sản phẩm từ cơ sở dữ liệu
        $sql = "SELECT TenSP, Gia FROM sanpham WHERE MaSP = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Kiểm tra lỗi truy vấn
        if ($stmt->error) {
            echo "Lỗi truy vấn: " . $stmt->error;
        }

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $product_name = $product['TenSP'];
            $product_price = $product['Gia'];
            $quantity = $item['SoLuong'];

            // Tính tổng giá trị sản phẩm
            $total_price += $product_price * $quantity;

            // Lưu thông tin sản phẩm vào mảng
            $products[] = [
                'name' => $product_name,
                'price' => $product_price,
                'quantity' => $quantity
            ];
        } else {
            echo "Không tìm thấy sản phẩm với ID: " . $product_id;
        }
    }
}

// Kiểm tra nếu người dùng nhấn nút Đặt hàng
if (isset($_POST['submit_order'])) {
    // Nhận dữ liệu từ form
    $ho = $_POST['ho'];
    $ten = $_POST['ten'];
    $email = $_POST['email'];
    $sdt = $_POST['sdt'];
    $diachi = $_POST['diachi'];
    $tinh = $_POST['tinh'];
    $quan = $_POST['quan'];
    $huyen = $_POST['huyen'];
    $payment_method = $_POST['payment']; // Nhận phương thức thanh toán

    // Chuẩn bị câu lệnh SQL để lưu đơn hàng vào bảng `orders`
    $sql = "INSERT INTO orders (ho, ten, email, sdt, diachi, tinh, quan, huyen, payment_method, total_price) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $total_order_price = $total_price + $shipping_fee; // Tính tổng giá đơn hàng

    // Ràng buộc tham số
    $stmt->bind_param("ssssssssss", $ho, $ten, $email, $sdt, $diachi, $tinh, $quan, $huyen, $payment_method, $total_order_price);

    if ($stmt->execute()) {
        // Nếu lưu thành công
        echo "<script>alert('Đơn hàng của bạn đã được đặt thành công. Cảm ơn bạn đã mua hàng!');</script>";
        // Xóa giỏ hàng sau khi đặt hàng thành công
        unset($_SESSION['cart']);
    } else {
        // Nếu có lỗi trong quá trình lưu
        echo "<script>alert('Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>MultiShop - Online Shop Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="../img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">  

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../lib/animate/animate.min.css" rel="stylesheet">
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../Accountcss/style.css" rel="stylesheet">
</head>

<body>

    <!-- Include file header -->
    <?php include "../inc/header.php"?>

    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="index.php">Trang chủ</a>
                    <a class="breadcrumb-item text-dark" href="shop.php">Sản phẩm</a>
                    <span class="breadcrumb-item active">Thanh toán</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Checkout Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Địa chỉ thanh toán</span></h5>
                <div class="bg-light p-30 mb-5">
                    <form action="checkout.php" method="POST">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Họ</label>
                                <input class="form-control" type="text" name="ho" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Tên</label>
                                <input class="form-control" type="text" name="ten" required>
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
                            <div class="col-md-6 form-group">
                                <label>Tỉnh thành</label>
                                <input class="form-control" type="text" name="tinh" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Quận</label>
                                <input class="form-control" type="text" name="quan" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Huyện</label>
                                <input class="form-control" type="text" name="huyen" required>
                            </div>
                        </div>
                        <div class="mb-5">
                            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Thanh toán</span></h5>
                            <div class="bg-light p-30">
                                <div class="form-group">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="payment" id="paypal" value="momo" required>
                                        <label class="custom-control-label" for="paypal">Thanh toán qua MoMo</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="payment" id="directcheck" value="direct" required>
                                        <label class="custom-control-label" for="directcheck">Thanh toán trực tiếp</label>
                                    </div>
                                </div>
                                <button type="submit" name="submit_order" class="btn btn-block btn-primary font-weight-bold py-3">Đặt hàng</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Tổng số thanh toán</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom">
                        <h6 class="mb-3">Sản phẩm</h6>
                        <?php foreach ($products as $product): ?>
                            <div class="d-flex justify-content-between">
                                <p><?php echo $product['name']; ?> (x<?php echo $product['quantity']; ?>)</p>
                                <p>$<?php echo $product['price']; ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="border-bottom pt-3 pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Tổng giá sản phẩm</h6>
                            <p>$<?php echo $total_price; ?></p>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Phí vận chuyển</h6>
                            <p>$<?php echo $shipping_fee; ?></p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6>Tổng số thanh toán</h6>
                            <h6>$<?php echo $total_price + $shipping_fee; ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Checkout End -->

    <!-- Include file footer -->
    <?php include "../inc/footer.php"?>
</body>
</html>

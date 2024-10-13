<?php
session_start();
ob_start(); // Bắt đầu output buffering
include "../inc/header.php";

// Kiểm tra giỏ hàng có sản phẩm chưa
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Xử lý thêm sản phẩm
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $product_id = $_POST['MaSP'];
    $product_name = $_POST['TenSP']; // Tên sản phẩm
    $product_price = $_POST['DonGiaNhap']; // Giá sản phẩm
    $found = false;

    // Tìm sản phẩm trong giỏ hàng
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['MaSP'] === $product_id) {
            $item['SoLuong'] += 1; // Tăng số lượng
            $found = true;
            break; // Dừng vòng lặp khi đã tìm thấy sản phẩm
        }
    }

    // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới
    if (!$found) {
        $_SESSION['cart'][] = array(
            'MaSP' => $product_id,
            'TenSP' => $product_name,
            'DonGiaNhap' => $product_price,
            'SoLuong' => 1
        );
    }

    // Chuyển hướng về trang giỏ hàng
    header("Location: cart.php");
    exit();
}

// Xử lý tăng giảm số lượng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $product_id = $_POST['MaSP'];
    $action = $_POST['action'];

    // Tìm sản phẩm trong giỏ hàng
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['MaSP'] === $product_id) {
            if ($action === 'increase') {
                $item['SoLuong'] += 1; // Tăng số lượng
            } elseif ($action === 'decrease') {
                if ($item['SoLuong'] > 1) {
                    $item['SoLuong'] -= 1; // Giảm số lượng
                }
            }
            break; // Dừng vòng lặp khi đã tìm thấy sản phẩm
        }
    }
    // Chuyển hướng về trang giỏ hàng
    header("Location: cart.php");
    exit();
}

// Hiển thị giỏ hàng
?>
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            <?php 
            if (empty($_SESSION['cart'])) {
                echo "<div class='container'><h2>Giỏ hàng của bạn đang trống.</h2></div>";
                $total = 0; // Khởi tạo tổng bằng 0 khi giỏ hàng trống
            } else {
                echo "<h2 class='mb-4'>Giỏ hàng của bạn</h2>";
                echo "<table class='table table-light table-borderless table-hover text-center mb-0'>";
                echo "<thead class='thead-dark'><tr><th>ID</th><th>Tên sản phẩm</th><th>Giá</th><th>Số lượng</th><th>Tổng tiền</th><th>Thao tác</th></tr></thead><tbody>";

                $total = 0; // Khởi tạo biến tổng
                foreach ($_SESSION['cart'] as $item) {
                    // Tính tổng tiền cho mỗi sản phẩm (Giá * Số lượng)
                    $item_total = $item['DonGiaNhap'] * $item['SoLuong'];

                    echo "<tr>";
                    echo "<td>" . $item['MaSP'] . "</td>";
                    echo "<td>" . $item['TenSP'] . "</td>";
                    echo "<td>" . number_format($item['DonGiaNhap']) . " VNĐ</td>";
                    echo "<td>
                             <form action='' method='POST' style='display:inline-flex; align-items: center;'>
                                <input type='hidden' name='MaSP' value='" . $item['MaSP'] . "'>
                                <button type='submit' name='action' value='decrease' class='btn btn-sm btn-primary mx-1' style='width: 30px;'>-</button>
                                <input type='text' name='SoLuong' value='" . $item['SoLuong'] . "' readonly style='width: 40px; text-align: center;' class='form-control mx-1'>
                                <button type='submit' name='action' value='increase' class='btn btn-sm btn-primary mx-1' style='width: 30px;'>+</button>
                            </form>
                          </td>";
                    echo "<td>" . number_format($item_total) . " VNĐ</td>";
                    echo "<td><a href='remove_cart_item.php?MaSP=" . $item['MaSP'] . "' class='btn btn-sm btn-danger'><i class='fa fa-times'></i></a></td>";
                    echo "</tr>";

                    // Cộng tổng tiền cho tất cả các sản phẩm trong giỏ hàng
                    $total += $item_total;
                }

                echo "<tr><td colspan='4'>Tổng cộng</td><td>" . number_format($total) . " VNĐ</td><td></td></tr>";
                echo "</tbody></table>";
            }
            ?>
        </div>
        
        <!-- Phần tóm tắt giỏ hàng -->
        <div class="col-lg-4">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Tóm tắt giỏ hàng</span></h5>
            <div class="bg-light p-30 mb-5">
                <?php if (!empty($_SESSION['cart'])): ?>
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Tổng phụ</h6>
                            <h6>
                                <?php
                                $subtotal = $total; // Sử dụng tổng từ giỏ hàng
                                echo number_format($subtotal); 
                                ?>
                            </h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Vận chuyển</h6>
                            <h6 class="font-weight-medium">30,000 VNĐ</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Tổng tiền</h5>
                            <h5><?php echo number_format(($subtotal) + 30000); ?> VNĐ</h5>
                        </div>
                        <a href="checkout.php">
                            <button class="btn btn-block btn-primary font-weight-bold my-3 py-3">Tiến hành thanh toán</button>
                        </a>
                    </div>
                <?php else: ?>
                    <div class="border-bottom pb-2">
                        <h6>Không có sản phẩm nào trong giỏ hàng.</h6>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
ob_end_flush(); // Kết thúc output buffering
include "../inc/footer.php";
?>

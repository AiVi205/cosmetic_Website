<?php
session_start();
include "../inc/database.php";
include '../inc/header.php';

$cart_items = [];

if (isset($_SESSION['MaND'])) {
    // Lấy giỏ hàng từ cơ sở dữ liệu
    $user_id = $_SESSION['MaND'];
    $sql = "SELECT c.*, p.TenSP, p.GiaUuDai, p.DonGiaNhap FROM giohang c JOIN sanpham p ON c.MaSP = p.MaSP WHERE c.MaND = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $cart_items[] = $row;
    }
} else {
    // Lấy giỏ hàng từ session
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $product_id => $details) {
            $sql = "SELECT * FROM sanpham WHERE MaSP = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $product = $result->fetch_assoc();
            $product['SoLuong'] = $details['SoLuong'];
            $cart_items[] = $product;
        }
    }
}

// Xử lý tăng giảm số lượng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $product_id = $_POST['MaSP'];
    $action = $_POST['action'];

    // Cập nhật số lượng trong session hoặc cơ sở dữ liệu
    if (isset($_SESSION['MaND'])) {
        // Xử lý tăng giảm cho người dùng đã đăng nhập
        if ($action === 'increase') {
            $sql = "UPDATE giohang SET SoLuong = SoLuong + 1 WHERE MaSP = ? AND MaND = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $product_id, $user_id);
            $stmt->execute();
        } elseif ($action === 'decrease') {
            // Chỉ giảm khi số lượng lớn hơn 1
            $sql = "UPDATE giohang SET SoLuong = CASE WHEN SoLuong > 1 THEN SoLuong - 1 ELSE SoLuong END WHERE MaSP = ? AND MaND = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $product_id, $user_id);
            $stmt->execute();
        }
    } else {
        // Xử lý tăng giảm cho người dùng chưa đăng nhập
        if (isset($_SESSION['cart'][$product_id])) {
            if ($action === 'increase') {
                $_SESSION['cart'][$product_id]['SoLuong'] += 1; // Tăng số lượng thêm 1
            } elseif ($action === 'decrease') {
                if ($_SESSION['cart'][$product_id]['SoLuong'] > 1) {
                    $_SESSION['cart'][$product_id]['SoLuong'] -= 1; // Giảm số lượng, không thấp hơn 1
                }
            }
        }
    }

    // Chuyển hướng về trang giỏ hàng để tránh gửi lại form
    header("Location: cart.php");
    exit();
}
?>

<!-- Hiển thị sản phẩm trong giỏ hàng -->
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

               // echo "<tr><td colspan='4'>Tổng cộng</td><td>" . number_format($total) . " VNĐ</td><td></td></tr>";
                echo "</tbody></table>";
            }
            ?>
            <?php if (!empty($cart_items)): ?>
                <h2 class="mb-4">Giỏ hàng của bạn</h2>
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng cộng</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        foreach ($cart_items as $item): 
                            $price = $item['GiaUuDai'] ?? $item['DonGiaNhap'];
                            $item_total = $item['SoLuong'] * $price;
                            $total += $item_total;
                        ?>
                            <tr>
                                <td><?php echo $item['TenSP']; ?></td>
                                <td><?php echo number_format($price); ?> VNĐ</td>
                                <td>
                                    <form action="" method="POST" style="display:inline-flex; align-items: center;">
                                        <input type="hidden" name="MaSP" value="<?php echo $item['MaSP']; ?>">
                                        <button type="submit" name="action" value="decrease" class="btn btn-sm btn-primary mx-1" style="width: 30px;">-</button>
                                        <input type="text" name="SoLuong" value="<?php echo $item['SoLuong']; ?>" readonly style="width: 40px; text-align: center;" class="form-control mx-1">
                                        <button type="submit" name="action" value="increase" class="btn btn-sm btn-primary mx-1" style="width: 30px;">+</button>
                                    </form>
                                </td>
                                <td><?php echo number_format($item_total); ?> VNĐ</td>
                                <td>
                                    <form action="remove_cart_item.php" method="POST">
                                        <input type="hidden" name="MaSP" value="<?php echo $item['MaSP']; ?>">
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Giỏ hàng của bạn trống.</p>
            <?php endif; ?>
        </div>
        
        <!-- Phần tóm tắt giỏ hàng -->
        <div class="col-lg-4">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Tóm tắt giỏ hàng</span></h5>
            <div class="bg-light p-30 mb-5">
                <?php if (!empty($cart_items)): ?>
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Tổng phụ</h6>
                            <h6><?php echo number_format($total); ?> VNĐ</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Vận chuyển</h6>
                            <h6 class="font-weight-medium">30,000 VNĐ</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Tổng tiền</h5>
                            <h5><?php echo number_format($total + 30000); ?> VNĐ</h5>
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

<?php include '../inc/footer.php'; ?>

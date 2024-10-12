<?php
session_start();
include '../inc/database.php'; // Ensure the path is correct

// Check if the user is logged in
if (!isset($_SESSION['MaND'])) {
    echo "Bạn cần đăng nhập để xem giỏ hàng.";
    exit();
}

$MaND = $_SESSION['MaND'];

// Fetch cart items from the database
$sql = "SELECT giohang.*, sanpham.TenSP, sanpham.DonGiaNhap, sanpham.ANhMH
        FROM giohang 
        INNER JOIN sanpham ON giohang.MaSP = sanpham.MaSP 
        WHERE giohang.MaND = $MaND";
$result = mysqli_query($conn, $sql);

// Handle quantity updates
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $MaSP = $_POST['MaSP'];
    $action = $_POST['action'];

    // Update quantity in the cart
    if ($action === 'increase') {
        $update_sql = "UPDATE giohang SET SoLuong = SoLuong + 1 WHERE MaND = $MaND AND MaSP = $MaSP";
    } elseif ($action === 'decrease') {
        $update_sql = "UPDATE giohang SET SoLuong = GREATEST(SoLuong -1, 0) WHERE MaND = $MaND AND MaSP = $MaSP";
    }
    mysqli_query($conn, $update_sql);

    // Update total price after modifying quantity
    $total_sql = "UPDATE giohang 
                   SET Tongtien = SoLuong * (SELECT DonGiaNhap FROM sanpham WHERE sanpham.MaSP = giohang.MaSP) 
                   WHERE MaND = $MaND AND MaSP = $MaSP";
    mysqli_query($conn, $total_sql);

    // Reload the cart page to apply changes
    header("Location: cart.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Giỏ Hàng - MultiShop</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="../img/favicon.ico" rel="icon">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
    <?php include "../inc/header.php"; ?>

    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) {
                            $product_total = $row['DonGiaNhap'] * $row['SoLuong']; ?>
                            <tr>
                                <td class="align-middle"><img src="../img/<?php echo $row['ANhMH']; ?>" alt="" style="width: 50px;"> <?php echo $row['TenSP']; ?></td>
                                <td class="align-middle"><?php echo $row['DonGiaNhap']; ?>VND</td>
                                <td class="align-middle">
                                    <form action="" method="POST" style="display: inline;">
                                        <input type="hidden" name="MaSP" value="<?php echo $row['MaSP']; ?>">
                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <button type="submit" name="action" value="decrease" class="btn btn-sm btn-primary btn-minus"><i class="fa fa-minus"></i></button>
                                            </div>
                                            <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center" value="<?php echo $row['SoLuong']; ?>" readonly>
                                            <div class="input-group-btn">
                                                <button type="submit" name="action" value="increase" class="btn btn-sm btn-primary btn-plus"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                                <td class="align-middle"><?php echo $product_total; ?>VND</td>
                                <td class="align-middle"><a href="remove_cart_item.php?MaSP=<?php echo $row['MaSP']; ?>" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Tổng phụ</h6>
                            <h6>
                                <?php
                                $total_sql = "SELECT SUM(sanpham.DonGiaNhap * giohang.SoLuong) AS subtotal 
                                              FROM giohang, sanpham 
                                              WHERE giohang.MaSP = sanpham.MaSP 
                                              AND giohang.MaND = $MaND";
                                $total_result = mysqli_query($conn, $total_sql);
                                $subtotal = 0; // Default value
                                if ($row = mysqli_fetch_assoc($total_result)) {
                                    $subtotal = $row['subtotal']; // Assign value if result exists
                                }
                                echo $subtotal;
                                ?>
                            </h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Vận chuyển</h6>
                            <h6 class="font-weight-medium">30000VNĐ</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Tổng tiền</h5>
                            <h5><?php echo $subtotal + 30000; ?> VNĐ</h5>
                        </div>
                        <a href="checkout.php">
                            <button class="btn btn-block btn-primary font-weight-bold my-3 py-3">Tiến hành thanh toán</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "../inc/footer.php"; ?>
</body>
</html>

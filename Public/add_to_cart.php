<?php
// session_start();
// include '../inc/database.php'; // Đảm bảo đường dẫn đúng

// // Kiểm tra xem form đã được gửi
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     // Kiểm tra nếu người dùng đã đăng nhập
//     if (!isset($_SESSION['MaND'])) {
//         echo "Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.";
//         exit();
//     }

//     // Lấy dữ liệu từ form
//     $MaSP = (int)$_POST['MaSP']; // Chuyển đổi thành kiểu số nguyên
//     $SoLuong = (int)$_POST['SoLuong']; // Giả sử số lượng sản phẩm được gửi từ form là `SoLuong`
//     $MaND = $_SESSION['MaND'];

//     // Kiểm tra nếu sản phẩm đã tồn tại trong giỏ hàng
//     $check_sql = "SELECT * FROM giohang WHERE MaSP = $MaSP AND MaND = $MaND";
//     $check_result = mysqli_query($conn, $check_sql);

//     if (!$check_result) {
//         // Kiểm tra lỗi SQL
//         die("Lỗi truy vấn: " . mysqli_error($conn));
//     }

//     if (mysqli_num_rows($check_result) > 0) {
//         // Nếu sản phẩm đã có, cập nhật số lượng
//         $update_sql = "UPDATE giohang SET SoLuong = SoLuong + $SoLuong WHERE MaSP = $MaSP AND MaND = $MaND";
//         if (!mysqli_query($conn, $update_sql)) {
//             // Kiểm tra lỗi SQL
//             die("Lỗi cập nhật giỏ hàng: " . mysqli_error($conn));
//         }

//         // Cập nhật giỏ hàng trong session
//         if (isset($_SESSION['cart'][$MaSP])) {
//             $_SESSION['cart'][$MaSP] += $SoLuong; // Cập nhật số lượng trong session
//         } else {
//             $_SESSION['cart'][$MaSP] = $SoLuong; // Nếu không tồn tại, khởi tạo số lượng
//         }
//     } else {
//         // Nếu sản phẩm chưa có, thêm mới vào giỏ hàng
//         $insert_sql = "INSERT INTO giohang (MaND, MaSP, SoLuong, Tongtien) 
//                        VALUES ($MaND, $MaSP, $SoLuong, (SELECT DonGiaNhap FROM sanpham WHERE MaSP = $MaSP))";
//         if (!mysqli_query($conn, $insert_sql)) {
//             // Kiểm tra lỗi SQL
//             die("Lỗi thêm sản phẩm vào giỏ hàng: " . mysqli_error($conn));
//         }

//         // Thêm sản phẩm vào giỏ hàng trong session
//         $_SESSION['cart'][$MaSP] = $SoLuong;
//     }

//     // Chuyển hướng về trang giỏ hàng
//     header("Location: index.php");
//     exit();
// }
?>
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

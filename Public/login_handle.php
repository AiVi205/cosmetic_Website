<?php
session_start(); // Bắt đầu session

include "../inc/database.php";

if (isset($_POST['Tai_Khoan']) && isset($_POST['your_pass'])) {
    $TaiKhoan = $_POST['Tai_Khoan'];
    $yourpass = $_POST['your_pass'];

    // Truy vấn tài khoản từ cơ sở dữ liệu
    $query = "SELECT * FROM nguoidung WHERE TaiKhoan = '$TaiKhoan'";
    $sql = mysqli_query($conn, $query);

    // Kiểm tra lỗi truy vấn
    if (!$sql) {
        echo "<script>alert('Lỗi truy vấn: " . mysqli_error($conn) . "');</script>";
        exit();
    }

    $array = mysqli_fetch_array($sql);
    if (!$array) {
        echo "<script>alert('Vui lòng nhập đúng tài khoản'); history.back();</script>";
        exit();
    } else {
        if ($array['MatKhau'] == $yourpass) {
            // Lưu thông tin đăng nhập vào session
            $_SESSION['TaiKhoan'] = $TaiKhoan;
            $_SESSION['MaND'] = $array['MaND']; // Nếu có cột MaND (Mã người dùng)
            
            // Kiểm tra nếu là admin
            if ($TaiKhoan == 'AIVI' && $yourpass == '123123') {
                header("Location: ../NiceAdmin/index.php");
                exit();
            } else {
                header("Location: index.php");
                exit();
            }
        } else {
            echo "<script>alert('Vui lòng nhập đúng mật khẩu'); history.back();</script>";
            exit();
        }
    }
}

$conn->close();
?>
<?php
<<<<<<< HEAD
// session_start(); // Bắt đầu session
// include "../inc/database.php"; // Kết nối cơ sở dữ liệu

// // Kiểm tra nếu form đăng nhập được gửi
// if (isset($_POST['Tai_Khoan']) && isset($_POST['your_pass'])) {
//     $TaiKhoan = $_POST['Tai_Khoan'];
//     $yourpass = $_POST['your_pass'];

//     // Truy vấn tài khoản từ cơ sở dữ liệu
//     $query = "SELECT * FROM nguoidung WHERE TaiKhoan = '$TaiKhoan'";
//     $sql = mysqli_query($conn, $query);

//     // Kiểm tra lỗi truy vấn
//     if (!$sql) {
//         echo "<script>alert('Lỗi truy vấn: " . mysqli_error($conn) . "');</script>";
//         exit();
//     }

//     $array = mysqli_fetch_array($sql);
//     if (!$array) {
//         echo "<script>alert('Vui lòng nhập đúng tài khoản'); history.back();</script>";
//         exit();
//     } else {
//         if ($array['MatKhau'] == $yourpass) {
//             // Lưu thông tin đăng nhập vào session
//             $_SESSION['TaiKhoan'] = $TaiKhoan;
//             $_SESSION['MaND'] = $array['MaND']; // Nếu có cột MaND (Mã người dùng)

//             // Lấy giỏ hàng từ cơ sở dữ liệu nếu người dùng có giỏ hàng trước đó
//             $MaND = $array['MaND']; // Mã người dùng từ kết quả truy vấn
//             $sql_cart = "SELECT * FROM giohang WHERE MaND = ?";
//             $stmt_cart = $conn->prepare($sql_cart);
//             $stmt_cart->bind_param("i", $MaND);
//             $stmt_cart->execute();
//             $result_cart = $stmt_cart->get_result();

//             // Khôi phục giỏ hàng vào session nếu có giỏ hàng cũ
//             $_SESSION['cart'] = array(); // Khởi tạo session giỏ hàng
//             while ($row = $result_cart->fetch_assoc()) {
//                 $_SESSION['cart'][] = array(
//                     'MaSP' => $row['MaSP'],
//                     'SoLuong' => $row['SoLuong'],
//                     'DonGiaNhap' => $row['DonGiaNhap'], // Lấy giá của sản phẩm từ cơ sở dữ liệu
//                     'TenSP' => $row['TenSP'] // Lấy tên sản phẩm từ cơ sở dữ liệu
//                 );
//             }

//             // Kiểm tra nếu là admin
//             if ($TaiKhoan == 'AIVI' && $yourpass == '123123') {
//                 header("Location: ../NiceAdmin/index.php");
//                 exit();
//             } else {
//                 header("Location: index.php");
//                 exit();
//             }
//         } else {
//             echo "<script>alert('Vui lòng nhập đúng mật khẩu'); history.back();</script>";
//             exit();
//         }
//     }
// }

// $conn->close(); // Đóng kết nối cơ sở dữ liệu
?>

=======
// session_start();
// include "../inc/database.php";

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $Tai_Khoan = $_POST['Tai_Khoan']; // Make sure this matches the correct form input name
//     $password = $_POST['your_pass']; // Make sure this matches the correct form input name

//     // Correct the column name here
//     $sql = "SELECT * FROM nguoidung WHERE TaiKhoan = ? AND MatKhau = ?"; // Change 'Email' to the correct column name for email
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("ss", $Tai_Khoan, $password);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     if ($result->num_rows > 0) {
//         $user = $result->fetch_assoc();
//         $_SESSION['MaND'] = $user['MAND'];

//         // Chuyển giỏ hàng từ session vào cơ sở dữ liệu nếu có
//         if (isset($_SESSION['cart'])) {
//             foreach ($_SESSION['cart'] as $product_id => $details) {
//                 $quantity = $details['SoLuong'];

//                 // Kiểm tra nếu sản phẩm đã tồn tại trong giỏ hàng
//                 $sql = "SELECT * FROM giohang WHERE MaND = ? AND MaSP = ?";
//                 $stmt = $conn->prepare($sql);
//                 $stmt->bind_param("ii", $_SESSION['MaND'], $product_id);
//                 $stmt->execute();
//                 $result = $stmt->get_result();

//                 if ($result->num_rows > 0) {
//                     // Nếu sản phẩm đã có trong giỏ hàng, tăng số lượng
//                     $sql = "UPDATE giohang SET SoLuong = SoLuong + ? WHERE MAND = ? AND MASP = ?";
//                     $stmt = $conn->prepare($sql);
//                     $stmt->bind_param("iii", $quantity, $_SESSION['MAND'], $product_id);
//                 } else {
//                     // Thêm sản phẩm mới vào giỏ hàng
//                     $sql = "INSERT INTO giohang (MaND, MaSP, SoLuong) VALUES (?, ?, ?)";
//                     $stmt = $conn->prepare($sql);
//                     $stmt->bind_param("iii", $_SESSION['MaND'], $product_id, $quantity);
//                 }
//                 $stmt->execute();
//             }
//             // Xóa giỏ hàng session sau khi chuyển vào DB
//             unset($_SESSION['cart']);
//         }

//         header("Location: index.php");
//         exit();
//     } else {
//         echo "Invalid email or password";
//     }
// }
?>


>>>>>>> 95795826f5d07d1087570b714babc47f4f9ba81b

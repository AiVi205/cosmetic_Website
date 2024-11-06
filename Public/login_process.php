<?php
// session_start(); // Bắt đầu session

// include "../inc/database.php";

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

// $conn->close();
?>

<?php
include '../inc/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hoten = $_POST['hoten'];
    $taikhoan = $_POST['taikhoan'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $re_pass = $_POST['re_pass'];
    $vaiTro = "Khach Hang";

    // Kiểm tra tài khoản đã tồn tại
    $result = $conn->query("SELECT * FROM nguoidung WHERE TaiKhoan='$taikhoan'");
    if ($result->num_rows > 0) {
        ?>
        <script>
            alert("Tài khoản đã tồn tại!!");
            history.back();
        </script>
        <?php
        exit();
    }

    // Kiểm tra xác nhận mật khẩu
    if ($re_pass != $pass) {
        ?>
        <script>
            alert("Xác nhận mật khẩu không trùng khớp!!");
            history.back();
        </script>
        <?php
        exit();
    }

    $sql = "INSERT INTO nguoidung (HoTen, TaiKhoan, Email, MatKhau, VaiTro) VALUES ('$hoten', '$taikhoan', '$email', '$pass', '$vaiTro')";
    
    if ($conn->query($sql) === true) {
        header("Location: login.php");
        exit();
    }
}

$conn->close(); // Đóng kết nối
?>
    
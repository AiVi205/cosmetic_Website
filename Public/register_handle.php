<?php
include '../inc/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hoten = $_POST['hoten'];
    $taikhoan = $_POST['taikhoan'];
    $email = $_POST['email'];
    $CCCD = $_POST['CCCD'];
    $SDT = $_POST['SDT'];
    $pass = $_POST['pass'];
    $re_pass = $_POST['re_pass'];
    $vaiTro = "Người dùng";

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

    // Kiểm tra email có hợp lệ không
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        ?>
        <script>
            alert("Định dạng email không hợp lệ!!");
            history.back();
        </script>
        <?php
        exit();
    }

    // Kiểm tra nếu CCCD chỉ chứa số
    if (!ctype_digit($CCCD)) {
        ?>
        <script>
            alert("CCCD chỉ được chứa số!!");
            history.back();
        </script>
        <?php
        exit();
    }

    // Kiểm tra nếu SDT chỉ chứa số
    if (!ctype_digit($SDT)) {
        ?>
        <script>
            alert("Số điện thoại chỉ được chứa số!!");
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

    // Nếu tất cả kiểm tra hợp lệ, chèn dữ liệu vào bảng nguoidung
    $sql = "INSERT INTO nguoidung (HoTen, TaiKhoan, Email, CCCD, SDT, MatKhau, VaiTro) 
            VALUES ('$hoten', '$taikhoan', '$email', '$CCCD', '$SDT', '$pass', '$vaiTro')";

    if ($conn->query($sql) === true) {
        header("Location: login.php"); // Chuyển hướng đến trang đăng nhập sau khi đăng ký thành công
        exit();
    } else {
        ?>
        <script>
            alert("Đăng ký thất bại. Vui lòng thử lại!!");
            history.back();
        </script>
        <?php
        exit();
    }
}

$conn->close(); // Đóng kết nối
?>

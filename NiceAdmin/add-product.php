<?php
include "../inc/database.php";

if (isset($_POST['add_product'])) {
    $ma_san_pham = $_POST['ma_san_pham'];
    $ten_san_pham = $_POST['ten_san_pham'];
    $mo_ta_sp = $_POST['mo_ta'];
    $thuong_hieu = $_POST['thuong_hieu'];
    $don_gia_nhap = $_POST['don_gia_nhap'];
    $gia_uu_dai = $_POST['gia_uu_dai']; // Lưu giá ưu đãi từ input
    $so_luong = $_POST['so_luong'];
    $ma_danh_muc = $_POST['ma_danh_muc'];

    if ($gia_uu_dai == "") {
        $gia_uu_dai = null; // Nếu không có giá ưu đãi thì gán là null
    }

    if (isset($_FILES['anhmh']) && $_FILES['anhmh']['error'] == 0) {
        $file = $_FILES['anhmh'];
        $imageName = $file['name'];
        $imageTmpName = $file['tmp_name'];
        $imagePath = 'img/' . $imageName;

        if (move_uploaded_file($imageTmpName, $imagePath)) {
            // Kiểm tra mã sản phẩm đã tồn tại
            $check_query = $conn->query("SELECT * FROM sanpham WHERE MaSP = '$ma_san_pham'");
            if ($check_query->num_rows > 0) {
                echo "Mã sản phẩm đã tồn tại.";
                exit();
            }

            // Lấy mã thương hiệu
            $thuong_hieu_query = $conn->query("SELECT MaThuongHieu FROM ThuongHieu WHERE TenThuongHieu = '$thuong_hieu'");
            if ($thuong_hieu_query->num_rows == 0) {
                echo "Tên thương hiệu không hợp lệ.";
                exit();
            }
            $thuong_hieu_row = $thuong_hieu_query->fetch_assoc();
            $ma_thuong_hieu = $thuong_hieu_row['MaThuongHieu'];

            // Kiểm tra mã danh mục
            $category_check = $conn->query("SELECT * FROM DanhMuc WHERE MaDanhMuc = '$ma_danh_muc'");
            if ($category_check->num_rows == 0) {
                echo "Mã danh mục không hợp lệ.";
                exit();
            }

            // Xử lý giá ưu đãi
            if ($gia_uu_dai === null) {
                $gia_uu_dai_sql = "NULL";
            } else {
                $gia_uu_dai_sql = "'$gia_uu_dai'";
            }

            $sql = "INSERT INTO sanpham (MaSP, TenSP, MoTa, MaThuongHieu, DonGiaNhap, GiaUuDai, SoLuongNhap, ANhMH, MaDanhMuc) 
                    VALUES ('$ma_san_pham', '$ten_san_pham', '$mo_ta_sp', '$ma_thuong_hieu', '$don_gia_nhap', $gia_uu_dai_sql, '$so_luong', '$imageName', '$ma_danh_muc')";

            if ($conn->query($sql) === TRUE) {
                $conn->query("UPDATE DanhMuc SET SoLuong = (SELECT COUNT(*) FROM SanPham WHERE MaDanhMuc = '$ma_danh_muc') WHERE MaDanhMuc = '$ma_danh_muc'");
                header("Location: form-product.php");
                exit();
            } else {
                echo "Thêm sản phẩm thất bại: " . $conn->error;
            }
        } else {
            echo "Lỗi khi di chuyển tệp ảnh!";
        }
    } else {
        echo "Lỗi khi upload ảnh hoặc không có ảnh!";
    }
}
?>

<?php 
include "../inc/database.php";

if(isset($_POST['update_product'])){
    $ma_san_pham = $_POST['ma_san_pham'];
    $ten_san_pham = $_POST['ten_san_pham'];
    $don_gia_nhap = $_POST['don_gia_nhap'];
    $gia_uu_dai = $_POST['gia_uu_dai'];
    $so_luong_nhap = $_POST['so_luong_nhap'];
    $ma_thuong_hieu = $_POST['ma_thuong_hieu'];
    $ma_danh_muc = $_POST['ma_danh_muc'];

    // Xử lý ảnh minh họa
    if(isset($_FILES['anhmh']) && $_FILES['anhmh']['name'] != '') {
        $anhmh = $_FILES['anhmh']['name'];
        move_uploaded_file($_FILES['anhmh']['tmp_name'], "img/".$anhmh);
    } else {
        $anhmh = $_POST['current_image']; // Sử dụng ảnh hiện tại nếu không tải ảnh mới
    }

    // Truy vấn UPDATE để cập nhật thông tin sản phẩm
    $query = "UPDATE sanpham SET 
                TenSP = '$ten_san_pham',
                DonGiaNhap = '$don_gia_nhap',
                GiaUuDai = '$gia_uu_dai',  -- Không cần kiểm tra, cập nhật trực tiếp giá trị
                SoLuong = '$so_luong_nhap',
                Images = '$anhmh',
                MaThuongHieu = '$ma_thuong_hieu',
                MaDanhMuc = '$ma_danh_muc'
              WHERE MaSP = '$ma_san_pham'";

    // Thực thi truy vấn
    if(mysqli_query($conn, $query)){
        echo "Cập nhật sản phẩm thành công!";
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}
?>

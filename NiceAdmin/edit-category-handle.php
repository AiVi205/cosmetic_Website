<?php
include "../inc/database.php";

if (isset($_POST['edit-category'])) {
    $tendanhmuc = $_POST['tendanhmuc'];
    $soluong = $_POST['soluong'];
    $ma_danh_muc = $_POST['ma_danh_muc']; // Lấy mã danh mục từ URL

    // Kiểm tra nếu người dùng chọn ảnh mới
    if (isset($_FILES['anhmh']) && $_FILES['anhmh']['name'] != '') {
        // Xử lý khi người dùng tải lên ảnh mới
        $anhmh = $_FILES['anhmh']['name'];
        move_uploaded_file($_FILES['anhmh']['tmp_name'], "img/" . $anhmh);
    } else {
        // Nếu không có ảnh mới thì giữ nguyên ảnh cũ
        $anhmh = $_POST['current_image']; // Sử dụng ảnh cũ
    }

    // Cập nhật danh mục vào cơ sở dữ liệu
    $query = "UPDATE DanhMuc SET TenDanhMuc = '$tendanhmuc', SoLuong = '$soluong', Images = '$anhmh' WHERE MaDanhMuc = '$ma_danh_muc'";
    
    if ($conn->query($query) === TRUE) {
        header("Location:tables-category.php");
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

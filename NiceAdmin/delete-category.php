<?php
include "../inc/database.php";

// Kiểm tra xem có mã danh mục được truyền qua URL hay không
if (isset($_GET['ma_danh_muc'])) {
    $ma_danh_muc = $_GET['ma_danh_muc'];

    // Kiểm tra xem danh mục có chứa sản phẩm hay không
    $query_check = "SELECT * FROM sanpham WHERE MaDanhMuc = '$ma_danh_muc'";
    $result_check = $conn->query($query_check);

    if ($result_check->num_rows > 0) {
        echo "<script>
                alert('Danh mục này không thể xóa vì còn sản phẩm trong đó.');
                history.back();
            </script>";
    } else {
        // Xóa danh mục khỏi cơ sở dữ liệu
        $query_delete = "DELETE FROM DanhMuc WHERE MaDanhMuc = '$ma_danh_muc'";
        if ($conn->query($query_delete) === TRUE) {
            echo"<script>
                alert('Danh mục đã được xóa thành công!');
            </script>";
            header("Location: tables-category.php");
        } else {
            echo "Lỗi: " . $conn->error;
        }
    }
} else {
    echo "Không có mã danh mục được truyền vào.";
}
?>
<?php
session_start();

// Hủy thông tin người dùng, nhưng giữ giỏ hàng trong cơ sở dữ liệu
session_unset(); // Xóa tất cả session nhưng giữ session giỏ hàng trong DB
session_destroy(); // Hủy bỏ phiên làm việc

// Chuyển hướng về trang chủ
header('Location: index.php');
exit();
?>
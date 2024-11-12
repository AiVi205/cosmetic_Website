<?php
// session_start();

// // Kiểm tra xem giỏ hàng có sản phẩm không
// if (!isset($_SESSION['cart'])) {
//     $_SESSION['cart'] = array();
// }

// // Kiểm tra nếu có tham số MaSP trong URL
// if (isset($_GET['MaSP'])) {
//     $product_id = $_GET['MaSP'];

//     // Tìm và xóa sản phẩm trong giỏ hàng
//     foreach ($_SESSION['cart'] as $key => $item) {
//         if ($item['MaSP'] === $product_id) {
//             unset($_SESSION['cart'][$key]); // Xóa sản phẩm
//             break; // Dừng vòng lặp khi đã tìm thấy sản phẩm
//         }
//     }
// }

// // Chuyển hướng về trang giỏ hàng
// header("Location: cart.php");
// exit();?>
<?php
session_start();
include "../inc/database.php";

if (isset($_POST['MaSP'])) {
    $product_id = $_POST['MaSP'];

    // Kiểm tra người dùng đã đăng nhập
    if (isset($_SESSION['MaND'])) {
        $user_id = $_SESSION['MaND'];
        
        // Xóa sản phẩm khỏi giỏ hàng trong cơ sở dữ liệu
        $sql = "DELETE FROM giohang WHERE MaND = ? AND MaSP = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        $stmt->close();
    } else {
        // Nếu chưa đăng nhập, xóa sản phẩm khỏi session
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
        }
    }
    
    // Chuyển hướng trở lại trang giỏ hàng
    header("Location: cart.php");
    exit();
}
?>

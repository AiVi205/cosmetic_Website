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
// exit();
<?php
session_start(); // Bắt đầu phiên làm việc

// Kiểm tra xem có thông tin để xóa không
if (isset($_POST['index'])) {
    $index = (int)$_POST['index'];
    
    // Xóa sản phẩm khỏi giỏ hàng
    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
    }

    // Để lại mảng giỏ hàng liên tục
    $_SESSION['cart'] = array_values($_SESSION['cart']);
}

// Chuyển hướng về trang giỏ hàng
header("Location: cart.php");
exit();
?>

?>

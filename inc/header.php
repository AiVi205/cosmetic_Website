<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Bắt đầu session nếu chưa có
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Favicon -->
    <link href="../img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../lib/animate/animate.min.css" rel="stylesheet">
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">

        <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
            <div class="col-lg-4">
                <a href="" class="text-decoration-none">
                    <span class="h1 text-uppercase text-primary bg-dark px-2">Multi</span>
                    <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">Shop</span>
                </a>
            </div>

            <div class="col-lg-5 col-6 text-left">
                <form action="search.php" method="POST">
                    <div class="input-group" style="height:50px;">
                        <input type="text" name="tukhoa" class="form-control h-100" placeholder="Tìm kiếm sản phẩm"
                            style="border-radius: 30px 0px 0px 30px;" required>
                        <div class="input-group-append">
                            <button type="submit" name="search_product" class="btn btn-primary"
                                style="border-radius: 0px 30px 30px 0px;">Tìm kiếm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <div class="container-fluid bg-dark mb-30">
        <div class="row px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-toggle="collapse"
                    href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                    <h6 class="text-dark m-0"><i class="fa fa-bars mr-2"></i></h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light"
                    id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                    <div class="navbar-nav w-100">
                        <div class="nav-item dropdown dropright">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Dresses <i
                                    class="fa fa-angle-right float-right mt-1"></i></a>
                            <div class="dropdown-menu position-absolute rounded-0 border-0 m-0">
                                <a href="" class="dropdown-item">Men's Dresses</a>
                                <a href="" class="dropdown-item">Women's Dresses</a>
                                <a href="" class="dropdown-item">Baby's Dresses</a>
                            </div>
                        </div>
                        <a href="" class="nav-item nav-link">Shirts</a>
                        <a href="" class="nav-item nav-link">Jeans</a>
                        <a href="" class="nav-item nav-link">Swimwear</a>
                        <a href="" class="nav-item nav-link">Sleepwear</a>
                        <a href="" class="nav-item nav-link">Sportswear</a>
                        <a href="" class="nav-item nav-link">Jumpsuits</a>
                        <a href="" class="nav-item nav-link">Blazers</a>
                        <a href="" class="nav-item nav-link">Jackets</a>
                        <a href="" class="nav-item nav-link">Shoes</a>
                    </div>
                </nav>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <span class="h1 text-uppercase text-dark bg-light px-2">Multi</span>
                        <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1">Shop</span>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="index.php" class="nav-item nav-link">Trang chủ</a>
                            <a href="#" class="nav-item nav-link">Giới thiệu</a>
                            <a href="Shop.php" class="nav-item nav-link">Sản phẩm</a>
                            <a href="#" class="nav-item nav-link">Tin tức</a>
                            <a href="contact.php" class="nav-item nav-link">Liên hệ</a>
                        </div>
                        <script>
                            function handleUserClick(event) {
                                event.preventDefault(); // Ngăn chặn hành động mặc định của liên kết

                                // Sử dụng câu lệnh if-else để kiểm tra đăng nhập
                                var isLoggedIn = false;
                                <?php
                                if (isset($_SESSION['TaiKhoan'])) {
                                    echo 'isLoggedIn = true;';
                                }
                                ?>

                                if (isLoggedIn) {
                                    // Gửi yêu cầu đăng xuất
                                    if (confirm('Bạn có chắc muốn đăng xuất không?')) {
                                        window.location.href = 'logout.php'; // Chuyển hướng đến trang đăng xuất
                                    }
                                } else {
                                    // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
                                    window.location.href = 'login.php';
                                }
                            }
                        </script>

                        <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                            <a href="login.php" class="btn px-0" onclick="handleUserClick(event)">
                                <img src="../img/logout.png" alt="" width="30">
                                <?php if (isset($_SESSION['TaiKhoan'])): ?>
                                    <span class="text-light"><?php echo htmlspecialchars($_SESSION['TaiKhoan']); ?></span>
                                <?php else: ?>
                                    <span class="text-light">Đăng nhập</span>
                                <?php endif; ?>
                            </a>

                            <!-- // Trong file header.php hoặc file bất kỳ có giỏ hàng -->
                            <?php
                            $total_quantity = 0; // Khởi tạo biến đếm số lượng
                            
                            // Đếm số lượng sản phẩm trong giỏ hàng
                            if (isset($_SESSION['cart'])) {
                                foreach ($_SESSION['cart'] as $quantity) {
                                    $total_quantity += $quantity; // Cộng dồn số lượng
                                }
                            }
                            ?>

                            <!-- Hiển thị số lượng trong icon giỏ hàng -->
                            <a href="cart.php" class="btn px-0 ml-3">
                                <i class="fas fa-shopping-cart text-primary"></i>
                                <span class="badge text-secondary border border-secondary rounded-circle"
                                    style="padding-bottom: 2px;">
                                    <?php echo $total_quantity; ?> <!-- Hiển thị số lượng giỏ hàng -->
                                </span>
                            </a>

                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Navbar End -->

    </div>
</body>

</html>
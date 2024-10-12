<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>MultiShop - Online Shop Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

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
    <?php include "../inc/header.php" ?>
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="index.php">Trang chủ</a>
                    <a class="breadcrumb-item text-dark" href="shop.php">Sản phẩm</a>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Shop Start -->
    <div class="container-fluid">
        <!-- Shop Product Start -->
        <div class="row px-xl-5">
            <?php
            include "../inc/database.php";

            // Truy vấn sản phẩm nổi bật
            $sql = "SELECT * FROM sanpham"; // Giới hạn 4 sản phẩm
            $resultSanPham = $conn->query($sql);

            if ($resultSanPham->num_rows > 0):
                while ($row = $resultSanPham->fetch_assoc()): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                        <div class="product-item bg-light mb-4">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100"
                                    src="../NiceAdmin/img/<?php echo htmlspecialchars($row['ANhMH']); ?>" alt="">
                                <div class="product-action">
                                    <form action="add_to_cart.php" method="POST">
                                        <input type="hidden" name="MaSP" value="<?php echo htmlspecialchars($row['MaSP']); ?>">
                                        <input type="hidden" name="TenSP"
                                            value="<?php echo htmlspecialchars($row['TenSP']); ?>">
                                        <input type="hidden" name="SoLuong" value="1">
                                        <?php
                                        if ($row['GiaUuDai'] != NULL && $row['GiaUuDai'] > 0) {
                                            $tongTien = $row['GiaUuDai'];
                                        } else {
                                            $tongTien = $row['DonGiaNhap'];
                                        }
                                        ?>
                                        <input type="hidden" name="TongTien" value="<?php echo $tongTien; ?>">

                                        <button type="submit" class="btn" style="display: flex; align-items: center;">
                                            <a class="btn btn-outline-dark btn-square" href="#"><i
                                                    class="fa fa-shopping-cart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="far fa-heart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href="#"><i
                                                    class="fa fa-sync-alt"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-search"></i></a>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="#"
                                    style="max-width: 200px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo $row['TenSP']; ?></a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <?php
                                    // Kiểm tra giá ưu đãi và gán giá hiện tại
                                    if ($row['GiaUuDai'] != NULL && $row['GiaUuDai'] > 0) {
                                        $giaHienTai = $row['GiaUuDai'];
                                    } else {
                                        $giaHienTai = $row['DonGiaNhap'];
                                    }
                                    ?>
                                    <h5><?php echo $giaHienTai; ?> VNĐ</h5>
                                    <?php if ($row['GiaUuDai'] != NULL && $row['GiaUuDai'] > 0): ?>
                                        <h6 class="text-muted ml-2"><del><?php echo $row['DonGiaNhap']; ?> VNĐ</del></h6>
                                    <?php endif; ?>
                                </div>

                                <div class="d-flex align-items-center justify-content-center mb-1">
                                    <?php for ($i = 0; $i < 5; $i++): ?>
                                        <small class="fa fa-star text-primary mr-1"></small>
                                    <?php endfor; ?>
                                    <small>(99)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Không có sản phẩm.</p>
            <?php endif; ?>

        </div>
        <!-- Shop Product End -->
        <div class="col-12">
            <nav>
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled"><a class="page-link" href="#">Previous</span></a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav>
        </div>
    </div>
    </div>
    <!-- Shop End -->
    <?php include "../inc/footer.php" ?>
    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="../mail/jqBootstrapValidation.min.js"></script>
    <script src="../mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
</body>

</html>
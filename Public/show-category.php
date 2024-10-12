<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm theo danh mục</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
    <?php include "../inc/header.php"; ?>
    <div class="container-fluid pt-5 pb-3">
        <?php
        include "../inc/database.php";

        // Kiểm tra nếu có mã danh mục trong URL
        if (isset($_GET['ma_danh_muc'])) {
            $ma_danh_muc = $_GET['ma_danh_muc'];

            // Truy vấn để lấy tên danh mục
            // Truy vấn để lấy tên danh mục
            $sqlDanhMuc = "SELECT TenDanhMuc FROM DanhMuc WHERE MaDanhMuc = '$ma_danh_muc'";
            $resultDanhMuc = $conn->query($sqlDanhMuc);

            if ($resultDanhMuc->num_rows > 0) {
                $tenDanhMuc = $resultDanhMuc->fetch_assoc()['TenDanhMuc'];
            } else {
                $tenDanhMuc = '';
            }


            // Hiển thị tên danh mục
            if ($tenDanhMuc) {
                echo '<h3 class="text-center mb-4 text-uppercase">' . ($tenDanhMuc) . '</h3>';
            } else {
                echo '<h3 class="text-center mb-4">Danh mục không hợp lệ.</h3>';
            }

            // Truy vấn để lấy tất cả sản phẩm thuộc danh mục
            $sql = "SELECT * FROM sanpham WHERE MaDanhMuc = '$ma_danh_muc'";
            $result = $conn->query($sql);

            echo '<div class="row px-xl-5">';
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                        <div class="product-item bg-light mb-4">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="../NiceAdmin/img/<?php echo htmlspecialchars($row['ANhMH']); ?>"
                                    alt="">
                                <div class="product-action">
                                    <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-shopping-cart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href="#"><i class="far fa-heart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-sync-alt"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="#"
                                    style="max-width: 200px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo $row['TenSP']; ?></a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <?php if ($row['GiaUuDai'] !== NULL && $row['GiaUuDai'] > 0): ?>
                                        <h5><?php echo $row['GiaUuDai']; ?> VNĐ</h5>
                                        <h6 class="text-muted ml-2"><del><?php echo $row['DonGiaNhap']; ?> VNĐ</del>
                                        </h6>
                                    <?php else: ?>
                                        <h5><?php echo $row['DonGiaNhap']; ?> VNĐ</h5>
                                    <?php endif; ?>
                                </div>

                                <div class="d-flex align-items-center justify-content-center mb-1">
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small>(99)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<div class="col-12"><p class="text-center">Không có sản phẩm nào trong danh mục này.</p></div>';
            }
            echo '</div>'; // Đóng div row
        } else {
            echo '<div class="col-12"><p class="text-center">Mã danh mục không hợp lệ.</p></div>';
        }
        ?>
        <?php include "../inc/footer.php"; ?>
    </div>
</body>

</html>
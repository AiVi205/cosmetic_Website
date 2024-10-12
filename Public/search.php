<?php
include '../inc/header.php';
include '../inc/database.php';
?>

<div class="main">
    <div class="content">
        <?php
        if (isset($_POST['search_product'])) {
            $tukhoa = $_POST['tukhoa'];
            $searchTerm = "%" . $conn->real_escape_string($tukhoa) . "%"; // Bảo mật đầu vào
        
            // Truy vấn sản phẩm
            $sql = "SELECT * FROM sanpham WHERE TenSP LIKE '$searchTerm'";
            $resultSanPham = $conn->query($sql);

            // Hiển thị kết quả
            ?>
            <div class="row px-xl-5">
                <h2>Kết quả tìm kiếm cho <strong><?php echo "'" . $tukhoa . "'"; ?></strong></h2>
            </div>
            <div class="row px-xl-5">
                <?php
                if ($resultSanPham->num_rows > 0) {
                    while ($row = $resultSanPham->fetch_assoc()) {
                        ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                            <div class="product-item bg-light mb-4">
                                <div class="product-img position-relative overflow-hidden">
                                    <img class="img-fluid w-100"
                                        src="../NiceAdmin/img/<?php echo htmlspecialchars($row['ANhMH']); ?>" alt="">
                                    <div class="product-action">
                                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                        <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                                    </div>
                                </div>
                                <div class="text-center py-4">
                                    <a class="h6 text-decoration-none text-truncate" href=""
                                        style="max-width: 200px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo htmlspecialchars($row['TenSP']); ?></a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h5><?php echo htmlspecialchars($row['GiaUuDai']); ?> VNĐ</h5>
                                        <h6 class="text-muted ml-2"><del><?php echo htmlspecialchars($row['DonGiaNhap']); ?>
                                                VNĐ</del></h6>
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
                    echo '<p>Không có sản phẩm.</p>';
                }
                ?>
            </div> <!-- Kết thúc div.row -->
            <?php
        }
        $conn->close();
        ?>
    </div>
</div>

<?php include '../inc/footer.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $conn = mysqli_connect('localhost', 'root', '') or die('Lỗi kết nối!');
    mysqli_set_charset($conn, "utf8");

    // Check if database exists, create it if not
    $createdb = "CREATE DATABASE loficosmetic";
    mysqli_query($conn, $createdb);
    $conn = mysqli_connect('localhost', 'root', '', 'loficosmetic') or die('Lỗi kết nối');
    mysqli_set_charset($conn, "utf8");
    if (!$conn) {
        die('Could not connect: ' . mysqli_connect_error());
    }
    echo "Kết nối thành công";

    // Tạo bảng comment
$sql = "CREATE TABLE comment (
    MaComment INT(11) NOT NULL AUTO_INCREMENT,
    MaSP VARCHAR(10) DEFAULT NULL,
    MaND INT(11) DEFAULT NULL,
    NoiDung TEXT DEFAULT NULL,
    NgayBinhLuan DATETIME DEFAULT CURRENT_TIMESTAMP(),
    PRIMARY KEY (MaComment),
    KEY (MaSP),
    KEY (MaND),
    FOREIGN KEY (MaSP) REFERENCES sanpham (MaSP) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (MaND) REFERENCES nguoidung (MaND) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if ($conn->query($sql) !== TRUE) {
    echo "Lỗi tạo bảng comment: " . $conn->error;
}

// Tạo bảng cthd
$sql = "CREATE TABLE cthd (
    MaSP VARCHAR(10) NOT NULL,
    MaDonHang INT(11) NOT NULL,
    DonGiaBan INT(11) DEFAULT NULL,
    SoLuongBan INT(11) DEFAULT NULL,
    ThanhTien FLOAT DEFAULT NULL,
    PRIMARY KEY (MaSP, MaDonHang),
    FOREIGN KEY (MaSP) REFERENCES sanpham (MaSP) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (MaDonHang) REFERENCES donhang (MaDonHang) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if ($conn->query($sql) !== TRUE) {
    echo "Lỗi tạo bảng cthd: " . $conn->error;
}

// Tạo bảng danhmuc
$sql = "CREATE TABLE danhmuc (
    MaDanhMuc INT(11) NOT NULL AUTO_INCREMENT,
    TenDanhMuc VARCHAR(100) NOT NULL,
    Images VARCHAR(100) DEFAULT NULL,
    SoLuong INT(11) DEFAULT NULL,
    PRIMARY KEY (MaDanhMuc)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if ($conn->query($sql) !== TRUE) {
    echo "Lỗi tạo bảng danhmuc: " . $conn->error;
}

// Tạo bảng donhang
$sql = "CREATE TABLE donhang (
    MaDonHang INT(11) NOT NULL AUTO_INCREMENT,
    MaND INT(11) DEFAULT NULL,
    NgayDH DATETIME DEFAULT NULL,
    TongTien FLOAT DEFAULT NULL,
    TrangThai ENUM('chờ xử lý','Đã gửi','Đã nhận','Đã hủy') DEFAULT 'chờ xử lý',
    PRIMARY KEY (MaDonHang),
    FOREIGN KEY (MaND) REFERENCES nguoidung (MaND) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if ($conn->query($sql) !== TRUE) {
    echo "Lỗi tạo bảng donhang: " . $conn->error;
}

// Tạo bảng giohang
$sql = "CREATE TABLE giohang (
    MaGioHang INT(11) NOT NULL AUTO_INCREMENT,
    MaND INT(11) DEFAULT NULL,
    MaSP VARCHAR(10) DEFAULT NULL,
    SoLuong INT(11) DEFAULT NULL,
    Tongtien INT(11) NOT NULL,
    NgayThem DATETIME DEFAULT CURRENT_TIMESTAMP(),
    PRIMARY KEY (MaGioHang),
    FOREIGN KEY (MaSP) REFERENCES sanpham (MaSP) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (MaND) REFERENCES nguoidung (MaND) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if ($conn->query($sql) !== TRUE) {
    echo "Lỗi tạo bảng giohang: " . $conn->error;
}

// Tạo bảng khuyenmai
$sql = "CREATE TABLE khuyenmai (
    MaKhuyenMai VARCHAR(255) NOT NULL,
    GiaTri FLOAT DEFAULT NULL,
    NgayBD DATE DEFAULT NULL,
    NgayKT DATE DEFAULT NULL,
    PRIMARY KEY (MaKhuyenMai)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if ($conn->query($sql) !== TRUE) {
    echo "Lỗi tạo bảng khuyenmai: " . $conn->error;
}

// Tạo bảng nguoidung
$sql = "CREATE TABLE nguoidung (
    MaND INT(11) NOT NULL AUTO_INCREMENT,
    HoTen VARCHAR(255) DEFAULT NULL,
    TaiKhoan VARCHAR(100) DEFAULT NULL,
    Email VARCHAR(255) DEFAULT NULL,
    MatKhau VARCHAR(255) DEFAULT NULL,
    VaiTro ENUM('Khách hàng','Quản trị viên') DEFAULT NULL,
    PRIMARY KEY (MaND)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if ($conn->query($sql) !== TRUE) {
    echo "Lỗi tạo bảng nguoidung: " . $conn->error;
}

// Tạo bảng sanpham
$sql = "CREATE TABLE sanpham (
    MaSP VARCHAR(10) NOT NULL,
    TenSP VARCHAR(200) NOT NULL,
    MoTa VARCHAR(2000) NOT NULL,
    MaThuongHieu VARCHAR(30) NOT NULL,
    DonGiaNhap INT(11) NOT NULL,
    GiaUuDai INT(11) DEFAULT NULL,
    SoLuongNhap INT(11) DEFAULT NULL,
    ANhMH VARCHAR(30) DEFAULT NULL,
    MaDanhMuc INT(11) DEFAULT NULL,
    PRIMARY KEY (MaSP),
    FOREIGN KEY (MaDanhMuc) REFERENCES danhmuc (MaDanhMuc) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (MaThuongHieu) REFERENCES thuonghieu (MaThuongHieu) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if ($conn->query($sql) !== TRUE) {
    echo "Lỗi tạo bảng sanpham: " . $conn->error;
}

// Tạo bảng thuonghieu
$sql = "CREATE TABLE thuonghieu (
    MaThuongHieu INT(11) NOT NULL AUTO_INCREMENT,
    TenThuongHieu INT(11) NOT NULL,
    Images INT(11) NOT NULL,
    PRIMARY KEY (MaThuongHieu)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if ($conn->query($sql) !== TRUE) {
    echo "Lỗi tạo bảng thuonghieu: " . $conn->error;
}

// Tạo bảng tintuc
$sql = "CREATE TABLE tintuc (
    MaTinTuc INT(11) NOT NULL AUTO_INCREMENT,
    TieuDe VARCHAR(255) NOT NULL,
    NoiDung TEXT DEFAULT NULL,
    NgayDang DATETIME DEFAULT CURRENT_TIMESTAMP(),
    PRIMARY KEY (MaTinTuc)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if ($conn->query($sql) !== TRUE) {
    echo "Lỗi tạo bảng tintuc: " . $conn->error;
}

// Đóng kết nối
$conn->close();
?>
</body>

</html>
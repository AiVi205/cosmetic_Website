-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 12, 2024 lúc 04:06 PM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `loficosmetic`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comment`
--

CREATE TABLE `comment` (
  `MaComment` int(11) NOT NULL,
  `MaSP` varchar(10) DEFAULT NULL,
  `MaND` int(11) DEFAULT NULL,
  `NoiDung` text DEFAULT NULL,
  `NgayBinhLuan` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cthd`
--

CREATE TABLE `cthd` (
  `MaSP` varchar(10) NOT NULL,
  `MaDonHang` int(11) NOT NULL,
  `DonGiaBan` int(11) DEFAULT NULL,
  `SoLuongBan` int(11) DEFAULT NULL,
  `ThanhTien` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhmuc`
--

CREATE TABLE `danhmuc` (
  `MaDanhMuc` int(11) NOT NULL,
  `TenDanhMuc` varchar(100) NOT NULL,
  `Images` varchar(100) DEFAULT NULL,
  `SoLuong` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `danhmuc`
--

INSERT INTO `danhmuc` (`MaDanhMuc`, `TenDanhMuc`, `Images`, `SoLuong`) VALUES
(25, 'Che khuyết điểm', 'chekhuyetdiem.jpg', 5),
(26, 'Kem lót', 'kemlot.jpg', 0),
(27, 'Kem nền', 'kemnen.jpg', 0),
(28, 'Má hồng', 'mahong.jpg', 0),
(29, 'Cushoin', 'cushoin.jpg', 0),
(30, 'Phấn phủ', 'phanphu.jpg', 0),
(31, 'Phấn mắt', 'phanmat.jpg', 0),
(32, 'Son', 'son.jpg', 0),
(33, 'Kem chống nắng', 'kcn.jpg', 0),
(34, 'Nước tẩy trang', 'taytrang.jpg', 0),
(35, 'Sữa rửa mặt', 'srm.jpg', 0),
(36, 'Mascara', '5.4.jpg', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhang`
--

CREATE TABLE `donhang` (
  `MaDonHang` int(11) NOT NULL,
  `MaND` int(11) DEFAULT NULL,
  `NgayDH` datetime DEFAULT NULL,
  `TongTien` float DEFAULT NULL,
  `TrangThai` enum('chờ xử lý','Đã gửi','Đã nhận','Đã hủy') DEFAULT 'chờ xử lý'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `donhang`
--

INSERT INTO `donhang` (`MaDonHang`, `MaND`, `NgayDH`, `TongTien`, `TrangThai`) VALUES
(1, 2, '2024-09-28 10:00:00', 300000, 'Đã gửi');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giohang`
--

CREATE TABLE `giohang` (
  `MaGioHang` int(11) NOT NULL,
  `MaND` int(11) DEFAULT NULL,
  `MaSP` varchar(10) DEFAULT NULL,
  `SoLuong` int(11) DEFAULT NULL,
  `Tongtien` float NOT NULL,
  `NgayThem` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `giohang`
--

INSERT INTO `giohang` (`MaGioHang`, `MaND`, `MaSP`, `SoLuong`, `Tongtien`, `NgayThem`) VALUES
(13, 2, '4', 1, 168000, '2024-10-09 22:09:48');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoidung`
--

CREATE TABLE `nguoidung` (
  `MaND` int(11) NOT NULL,
  `TaiKhoan` varchar(255) NOT NULL,
  `MatKhau` varchar(255) NOT NULL,
  `HoTen` varchar(255) NOT NULL,
  `CCCD` varchar(20) NOT NULL,
  `SDT` varchar(15) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `VaiTro` enum('quản trị viên','người dùng') NOT NULL DEFAULT 'người dùng'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Đang đổ dữ liệu cho bảng `nguoidung`
--

INSERT INTO `nguoidung` (`MaND`, `TaiKhoan`, `MatKhau`, `HoTen`, `CCCD`, `SDT`, `Email`, `VaiTro`) VALUES
(1, 'AIVI', '123123', 'Admin', '123456789012', '0123456789', 'admin@example.com', 'quản trị viên'),
(2, 'CamNhung', '123', 'CamNhung', '987654321012', '0987654321', 'user1@example.com', 'người dùng'),
(5, 'Nhung', '123', 'Trần Thị Cẩm Nhung', '', '', 'Tranthicamnhung.3008@gmail.com', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `MaSP` varchar(10) NOT NULL,
  `TenSP` varchar(200) NOT NULL,
  `MoTa` varchar(2000) NOT NULL,
  `MaThuongHieu` varchar(30) NOT NULL,
  `DonGiaNhap` int(11) NOT NULL,
  `GiaUuDai` int(11) DEFAULT NULL,
  `SoLuongNhap` int(11) DEFAULT NULL,
  `ANhMH` varchar(30) DEFAULT NULL,
  `MaDanhMuc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`MaSP`, `TenSP`, `MoTa`, `MaThuongHieu`, `DonGiaNhap`, `GiaUuDai`, `SoLuongNhap`, `ANhMH`, `MaDanhMuc`) VALUES
('1', 'Che Khuyết Điểm The Saem Cover Perfection', '- Thương hiệu: The Saem  - Khối lượng: 6.5g  - Xuất xứ: Hàn Quốc    THÀNH PHẦN:  Titanium dioxide, water, cyclopentasiloxane, phenyl trimethicone, talc, cetyl peg/ppg-10/1 dimethicone, butylene glycol, peg-10 dimethicone, vinyl dimethicone/methicone silsesquioxane crosspolymer…  Trong đó, có một số thành phần nổi bật như:  Dimethicone: tạo độ mịn và hàng rào bảo vệ cho da cũng như duy trì độ ẩm tối ưu.   Butylene glycol: có khả năng giữ ẩm tuyệt vời và tăng độ thẩm thấu vào da, hạn chế tình trạng nhờn rít trên da.  Silsesquioxane crosspolymer: là một loại bột silicon hình cầu giúp làm mềm mịn và tạo hiệu ứng lì cho làn da.    CÔNG DỤNG:  Đối với những ai khuôn mặt có nhiều khuyết điểm, mụn, thâm, tàn nhang thì kem che khuyết điểm như một “công cụ đắc lực” giúp lớp makeup “xinh đẹp không tì vết”:  Những vết thâm mụn, mụn, nám, tàn nhang… sẽ biến mất ngay sau khi bạn sử dụng kem che khuyết điểm.  Che đi quầng thâm mắt thâm sạm.  Ngoài ra, sản phẩm còn giúp giữ màu son lâu hơn bằng cách đánh nhẹ một lớp kem che khuyết điểm trước khi đánh son.', '2', 95000, 79000, 120, 'R.png', 25),
('2', 'Kem che khuyết điểm JUDYDOLL', '👉Tên sản phẩm: Kem che khuyết điểm Judydoll Traceless Cloud-Touch Concealer     ✨Điểm nổi bật:  Độ che phủ cao, lâu trôi, tiệp da. Kem che khuyết điểm dạng lỏng giúp làm mờ sự  các khuyết điểm chuyên nghiệp.  【🔥 Khuyên dùng】  #01 Da trắng sáng  #02 Da tự nhiên  #03 Da ngăm    【☘️Chi tiết】  Nguồn gốc: Trung Quốc  Khối lượng tịnh: 3.2g  Thời hạn sử dụng: 3 năm    💓Giới thiệu thương hiệu:  Judydoll là thương hiệu trang điểm dẫn đầu xu hướng màu sắc, kết hợp hoàn hảo phong cách cá nhân và nhu cầu trang điểm cơ bản hàng ngày.  LấyJudydoll làm chủ đạo, chúng tôi tiếp tục duy trì sức mạnh sáng tạo ra những sản phẩm kinh điển và nhiệt huyết thể hiện cá tính. Judydoll sinh ra để dành cho cho các bạn trẻ năng động và yêu thích những điều mới mẻ, để bạn có thể dễ dàng khám phá mọi phong cách trang điểm mà bạn có thể tưởng tượng được.', '4', 220000, 180000, 150, 'judydoll.jpg', 25),
('3', 'Kem Che Khuyết Điểm PERIPERA', '🌈🌈🌈Peripera Double Longwear Cover Concealer🌈🌈🌈  Là kem che khuyết điểm nổi tiếng của Peripera với khả năng che phủ cao và bền màu lâu dài. Sản phẩm được nâng cấp từ phiên bản cũ với công thức bột kép giúp tăng cường hiệu quả che phủ và bám chặt trên da.🌈🌈🌈Ưu điểm🌈🌈🌈  🌾Khả năng che phủ cao: Che phủ tốt các khuyết điểm như thâm mụn, quầng thâm mắt, nám, tàn nhang, viền môi ...  🌾Bền màu lâu dài: Giữ lớp che khuyết điểm lâu trôi trong suốt cả ngày mà không bị xuống màu hay cakey.  🌾Kết cấu mỏng nhẹ: Dạng kem lỏng sánh mịn, dễ tán đều trên da và tạo cảm giác nhẹ mặt.  🌾Phù hợp với mọi loại da: Kể cả da nhạy cảm.', '5', 120000, NULL, 50, 'PERIPERA.jfif', 25),
('4', 'Kem che khuyết điểm Maybelline Fit me Concealer', 'Mint hiện có các tông:  10 Light:  Tone sáng phù hợp cho các bạn có làn da trắng. Hoặc các bạn da hơi ngăm có thể dung làm highlight.  15 Fair: Tone sáng base hồng. Trung hoà rất tốt với quầng thâm mắt tạo vẻ tự nhiên. Có thể làm highlight cho những bạn da hơi tái.  20 Sand: Tone trung bình phù hợp các bạn có tone da trung bình. Có thể coi là tone tự nhiên nhé!    Mint Cosmetics – Since 2014 - hệ thống mỹ phẩm uy tín với Slogan “Save The Best For You”. Cam kết chỉ bán hàng chính hãng, đồng hành thân thiết cùng các cô gái trên hành trình làm đẹp của mình.', '6', 168000, 150000, 90, 'Maybelline.jpg', 25),
('5', 'Kem che khuyết điểm kiềm dầu bền màu Lemonade Matte Addict Concealer', 'THÔNG TIN THƯƠNG HIỆU:  LEMONADE MANG ĐẾN  Giải Pháp Trang Điểm Dễ Dàng Cho Phụ Nữ Việt  Dựa trên kinh nghiệm 15 năm chinh chiến trong ngành làm đẹp và hợp tác với các tập đoàn mỹ phẩm nổi tiếng trên Thế giới, Makeup Artist Quách Ánh cùng những cộng sự của mình đã tạo nên thương hiệu mỹ phẩm Lemonade. Với các dòng sản phẩm đa công năng và tiện dụng được nghiên cứu dựa trên khí hậu và làn da của phụ nữ Việt, Lemonade giúp bạn hoàn thiện vẻ đẹp một cách nhanh chóng và dễ dàng hơn: Dễ dàng sử dụng, dễ dàng kết hợp và dễ dàng mang đi.    Thời gian sử dụng tốt nhất: 06 tháng từ khi mở nắp  HSD & NSX: 03 năm kể từ ngày SX (ghi trên bao bì)  Xuất xứ thương hiệu: Việt Nam  Sản xuất tại: Đài Loan  Khối lượng: 3 gram  Thành phần: Xem chi tiết trên bao bì sản phẩm', '7', 200000, 175000, 200, 'Lemonade.png', 25);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thuonghieu`
--

CREATE TABLE `thuonghieu` (
  `MaThuongHieu` varchar(30) NOT NULL,
  `TenThuongHieu` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `thuonghieu`
--

INSERT INTO `thuonghieu` (`MaThuongHieu`, `TenThuongHieu`) VALUES
('2', 'The Saem'),
('3', '\r\nZeesea'),
('4', 'JUDYDOLL '),
('5', 'PERIPERA '),
('6', 'Maybelline '),
('7', 'Lemonade '),
('Lofi Cosmetic', 'Lofi Cosmetic');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`MaComment`),
  ADD KEY `MaSP` (`MaSP`),
  ADD KEY `MaND` (`MaND`);

--
-- Chỉ mục cho bảng `cthd`
--
ALTER TABLE `cthd`
  ADD PRIMARY KEY (`MaSP`,`MaDonHang`),
  ADD KEY `MaDonHang` (`MaDonHang`);

--
-- Chỉ mục cho bảng `danhmuc`
--
ALTER TABLE `danhmuc`
  ADD PRIMARY KEY (`MaDanhMuc`);

--
-- Chỉ mục cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD PRIMARY KEY (`MaDonHang`),
  ADD KEY `MaND` (`MaND`);

--
-- Chỉ mục cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`MaGioHang`),
  ADD KEY `MaSP` (`MaSP`),
  ADD KEY `MaND` (`MaND`);

--
-- Chỉ mục cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`MaND`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`MaSP`),
  ADD KEY `MaDanhMuc` (`MaDanhMuc`),
  ADD KEY `MaThuongHieu` (`MaThuongHieu`);

--
-- Chỉ mục cho bảng `thuonghieu`
--
ALTER TABLE `thuonghieu`
  ADD PRIMARY KEY (`MaThuongHieu`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `comment`
--
ALTER TABLE `comment`
  MODIFY `MaComment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `danhmuc`
--
ALTER TABLE `danhmuc`
  MODIFY `MaDanhMuc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT cho bảng `donhang`
--
ALTER TABLE `donhang`
  MODIFY `MaDonHang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `giohang`
--
ALTER TABLE `giohang`
  MODIFY `MaGioHang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `MaND` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`MaND`) REFERENCES `nguoidung` (`MaND`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `cthd`
--
ALTER TABLE `cthd`
  ADD CONSTRAINT `cthd_ibfk_1` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cthd_ibfk_2` FOREIGN KEY (`MaDonHang`) REFERENCES `donhang` (`MaDonHang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `donhang_ibfk_1` FOREIGN KEY (`MaND`) REFERENCES `nguoidung` (`MaND`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD CONSTRAINT `giohang_ibfk_1` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `giohang_ibfk_2` FOREIGN KEY (`MaND`) REFERENCES `nguoidung` (`MaND`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`MaDanhMuc`) REFERENCES `danhmuc` (`MaDanhMuc`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sanpham_ibfk_2` FOREIGN KEY (`MaThuongHieu`) REFERENCES `thuonghieu` (`MaThuongHieu`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

<?php
    include "../inc/database.php"; 

    if (isset($_POST['add_category'])) {
        $TenDanhMuc = $_POST['tendanhmuc'];
        $SoLuong = $_POST['soluong'];

        if (isset($_FILES['anhmh']) && $_FILES['anhmh']['error'] == 0) {
            $file = $_FILES['anhmh'];
            $imageName = $file['name'];
            $imageTmpName = $file['tmp_name'];
            $imagePath = 'img/' . $imageName;

            if (move_uploaded_file($imageTmpName, $imagePath)) {
                $sql_insert = "INSERT INTO danhmuc (TenDanhMuc, SoLuong, Images) 
                               VALUES ('$TenDanhMuc', '$SoLuong', '$imageName')";

                if ($conn->query($sql_insert)) {
                    ?>
                    <script>
                        alert("Thêm thành công!!");
                    </script>
                    <?php
                    header("Location: form-category.php");
                    exit();
                } else {
                    echo "Thêm thất bại: " . $conn->error;
                }
            } else {
                echo "Lỗi khi di chuyển tệp ảnh!";
            }
        } else {
            echo "Lỗi khi upload ảnh hoặc không có ảnh!";
        }
    } else {
        echo "Bạn chưa nhấn nút submit!";
    }
?>

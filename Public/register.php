<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <?php include "../inc/header.php" ?>
    <div class="main">
                <!-- Sign up form -->
                <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Đăng Ký</h2>
                        <form method="POST" class="register-form" id="register-form" action="register_handle.php">
                        <div class="form-group">
                                <label for="name"><i class="fas fa-user"></i></label>
                                <input type="text" name="hoten" id="hoten" placeholder="Họ tên" required/>
                            </div>
                            <div class="form-group">
                                <label for="name"><i class="fas fa-user"></i></label>
                                <input type="text" name="taikhoan" id="taikhoan" placeholder="Tài khoản" required/>
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="fas fa-envelope"></i></label>
                                <input type="email" name="email" id="email" placeholder="Email" required/>
                            </div>
                            <div class="form-group">
                                <label for="CCCD"><i class="fas fa-envelope"></i></label>
                                <input type="CCCD" name="CCCD" id="CCCD" placeholder="CCCD" required/>
                            </div>
                            <div class="form-group">
                                <label for="SDT"><i class="fas fa-envelope"></i></label>
                                <input type="SDT" name="SDT" id="SDT" placeholder="SDT" required/>
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="fa fa-unlock-alt"></i></label>
                                <input type="password" name="pass" id="pass" placeholder="Mật khẩu" required/>
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="fa fa-unlock-alt"></i></label>
                                <input type="password" name="re_pass" id="re_pass" placeholder="Nhập lại mật khẩu" required/>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                                <label for="agree-term" class="label-agree-term"><span><span></span></span>Tôi đồng ý với tất cả</label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit btn-warning" value="Đăng Ký" />
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="../img/signup-image.jpg" alt="sing up image"></figure>
                        <a href="login.php" class="signup-image-link">Tôi đã có tài khoản<nav></nav></a>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php include "../inc/footer.php" ?>
</body>
</html>
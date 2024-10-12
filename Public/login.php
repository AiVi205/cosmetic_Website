<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

</head>

<body>
    <?php include "../inc/header.php" ?>
    
    <div class="main">

        <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="../img/signin-image.jpg" alt="sing up image"></figure>
                        <a href="register.php" class="signup-image-link">Tạo tài khoản</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Đăng Nhập</h2>
                        <form method="POST" class="register-form" id="login-form " action="login_handle.php">

                            <div class="form-group">
                                <label for="Tai_Khoan"><i class="fas fa-user"></i></label>
                                <input type="text" name="Tai_Khoan" id="Tai_Khoan" placeholder="Tài Khoản" required/>
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="fa fa-unlock-alt"></i></label>
                                <input type="password" name="your_pass" id="your_pass" placeholder="Mật khẩu" required/>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
                                <label for="remember-me" class="label-agree-term"><span><span></span></span>Ghi nhớ tất cả</label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit btn-warning" value="Đăng nhập" />
                            </div>
                        </form>
                        <div class="social-login">
                            <span class="social-label">Hoặc đăng nhập bằng</span>
                            <ul class="socials">
                                <li><a href="#"><img src="../img/facebook.png" alt="" width="30px"></a></li>
                                <li><a href="#"><img src="../img/twitter.png" alt="" width="30px"></a></li>
                                <li><a href="#"><img src="../img/google.png" alt="" width="30px"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <?php include "../inc/footer.php" ?>
</body>

</html>
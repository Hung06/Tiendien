<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="http://localhost/Tiendien/Views/Login.css">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
      integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer">
</head>
<body>
    <div class="wrapper wrapper-login">
        <div class="content-login">
            <form id="loginForm" method="post" action="../Controllers/LoginController.php">
                <div class="logo-Phenikaa-w justify-content-center d-flex">
                    <img src="http://localhost/Tiendien/img/logo-Phenikaa-w.png" class="img-logo-w">
                </div>
                <div class="content-form-login position-relative">
                    <h2 class="title-h2">Đăng nhập</h2>
                    <div class="form-item position-relative mb-20">
                        <label for="usernameF" class="form-label"><i class="fa-solid fa-user"></i></label>
                        <input name="usernameForm" type="text" id="Mail" class="form-control" placeholder="Nhập email" required>
                    </div>
                    <div class="form-item position-relative mb-20">
                        <label for="passwordF" class="form-label"><i class="fa-solid fa-key"></i></label>
                        <input name="passwordForm" id="Pass" type="password" class="form-control" placeholder="Nhập mật khẩu" required>
                    </div>
                    <div class="form-item position-relative mb-20">
                        <input type="checkbox" id="show-password" onclick="togglePassword()">
                        <label for="show-password">Hiển thị mật khẩu</label>
                    </div>
                    <input type="submit" name="login" value="Đăng nhập" class="btn btn-primary btn-login">
                    <br><br>
                    <input type="button" name="register" value="Đăng ký" class="btn btn-secondary btn-login" onclick="redirectToRegister()">
                    <!-- Thêm div để hiển thị thông báo lỗi -->
                    <div id="error-message" class="error-message">
                        <?php
                        if (isset($_GET['error'])) {
                            echo '<p style="color:red;">' . htmlspecialchars($_GET['error']) . '</p>';
                        }
                        ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
     <script>
        function redirectToRegister() {
            window.location.href = '../Views/RegisterView.php';
        }
        function togglePassword() {
            var passwordInput = document.getElementById("Pass");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }
    </script> 
</body>
</html>

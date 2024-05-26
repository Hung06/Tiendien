<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
    <link rel="stylesheet" href="http://localhost/Tiendien/Views/Login.css">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
      integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"></head>
<style>
    .relogin {
        width: 100%;
    }
    .dn {
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
    }
    .error-message {
        color: red;
        margin-top: 10px;
    }
</style>
<script>
function validateField(input) {
    const errorElement = input.nextElementSibling;
    if (/^\s/.test(input.value)) {
        errorElement.style.display = 'block';
        input.classList.add('is-invalid');
        errorElement.textContent = 'Trường này không được phép bắt đầu bằng dấu cách';
    } else {
        errorElement.style.display = 'none';
        input.classList.remove('is-invalid');
    }
}

function validateEmail(input) {
    const errorElement = input.nextElementSibling;
    const emailRegex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
    if (!emailRegex.test(input.value)) {
        errorElement.style.display = 'block';
        input.classList.add('is-invalid');
        errorElement.textContent = 'Email phải có định dạng xx@gmail.com';
    } else {
        errorElement.style.display = 'none';
        input.classList.remove('is-invalid');
    }
}

function validatePassword(input) {
    const errorElement = input.nextElementSibling;
    if (input.value.length < 8) {
        errorElement.style.display = 'block';
        input.classList.add('is-invalid');
        errorElement.textContent = 'Mật khẩu phải có ít nhất 8 ký tự';
    } else {
        errorElement.style.display = 'none';
        input.classList.remove('is-invalid');
    }
}

function validateForm() {
    let valid = true;
    const inputs = document.querySelectorAll('.form-control');
    
    inputs.forEach(input => {
        if (/^\s/.test(input.value)) {
            input.classList.add('is-invalid');
            const errorElement = input.nextElementSibling;
            errorElement.style.display = 'block';
            errorElement.textContent = 'Trường này không được phép bắt đầu bằng dấu cách';
            valid = false;
        } else {
            input.classList.remove('is-invalid');
            const errorElement = input.nextElementSibling;
            errorElement.style.display = 'none';
        }

        if (input.type === 'email') {
            validateEmail(input);
            if (!/^[a-zA-Z0-9._%+-]+@gmail\.com$/.test(input.value)) {
                valid = false;
            }
        }

        if (input.type === 'password') {
            validatePassword(input);
            if (input.value.length < 8) {
                valid = false;
            }
        }
    });

    if (!valid) {
        document.getElementById('formError').style.display = 'block';
        return false;
    } else {
        document.getElementById('formError').style.display = 'none';
        return true;
    }
}
</script>

<body>
    <div class="wrapper wrapper-login">
        <div class="content-login">
            <form method="post" action="../Controllers/RegisterController.php" onsubmit="return validateForm()">
                <div class="logo-Phenikaa-w justify-content-center d-flex">
                    <img src="http://localhost/Tiendien/img/logo-Phenikaa-w.png" class="img-logo-w">
                </div>
                <div class="content-form-login position-relative">
                    <h2 class="title-h2">Đăng Ký</h2>
                    <div class="form-item position-relative mb-20">
                        <label for="name" class="form-label"><i class="fa-solid fa-user"></i></label>
                        <input name="nameForm" type="text" id="name" class="form-control" placeholder="Nhập họ và tên" required oninput="validateField(this)">
                        <small class="text-danger" style="display: none; color: red;"></small>
                    </div>
                    <div class="form-item position-relative mb-20">
                        <label for="mkh" class="form-label"><i class="fa-solid fa-clipboard"></i></label>
                        <input name="mkhForm" type="text" id="mkh" class="form-control" placeholder="Nhập mã khách hàng" required oninput="validateField(this)">
                        <small class="text-danger" style="display: none; color: red;"></small>
                    </div>
                    <div class="form-item position-relative mb-20">
                        <label for="email" class="form-label"><i class="fa-solid fa-envelope"></i></label>
                        <input name="emailForm" type="email" id="email" class="form-control" placeholder="Nhập email" required oninput="validateEmail(this)">
                        <small class="text-danger" style="display: none; color: red;"></small>
                    </div>
                    <div class="form-item position-relative mb-20">
                        <label for="password" class="form-label"><i class="fa-solid fa-key"></i></label>
                        <input name="passwordForm" type="password" id="password" class="form-control" placeholder="Nhập mật khẩu" required oninput="validatePassword(this)">
                        <small class="text-danger" style="display: none; color: red;"></small>
                    </div>
                    <input type="submit" name="register" value="Đăng ký" class="btn btn-primary btn-login">
                    <br><br>
                    <div class="dn"><a href="../Views/LoginView.php" class="btn btn-primary btn-login relogin">Đăng Nhập</a></div>
                </div>
                <div id="formError" class="error-message" style="display: none;">Vui lòng kiểm tra lại các trường dữ liệu</div>
                <?php
                if (isset($_GET['error'])) {
                    echo '<div class="error-message">'.htmlspecialchars($_GET['error']).'</div>';
                }
                if (isset($_GET['success'])) {
                    echo '<div class="success-message">'.htmlspecialchars($_GET['success']).'</div>';
                }
                ?>
            </form>
        </div>
    </div>
</body>
</html>

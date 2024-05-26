<?php
include '../Models/LoginModel.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        $username = $_POST['usernameForm'];
        $password = $_POST['passwordForm'];

        // Debugging: print the received username and password
        error_log("Received Username: $username");
        error_log("Received Password: $password");

        try {
            // Prepare and execute the SQL statement with case-sensitive binary comparison
            $stmt = $db->prepare("SELECT * FROM Users WHERE BINARY Email = BINARY ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Debugging: check if the user was fetched
            if ($user) {
                error_log("User fetched: " . print_r($user, true));

                // Debugging: check the password comparison
                error_log("Comparing input password: $password with stored password: " . $user['MatKhau']);
                if ($password === $user['MatKhau']) {
                    // Lưu thông tin đăng nhập vào session
                    $_SESSION['IsLogin'] = true;
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['email'] = $user['Email'];
                    error_log("Login successful. Redirecting to DienView.php");

                    // Ensure no output has been sent
                    if (!headers_sent()) {
                        header("Location: ../Views/DienView.php");
                        exit;
                    } else {
                        error_log("Headers already sent. Cannot redirect.");
                        echo "<script>window.location.href = '../Views/DienView.php';</script>";
                        exit;
                    }
                } else {
                    error_log("Password mismatch");
                }
            } else {
                error_log("User not found");
            }
            header("Location: ../Views/LoginView.php?error=Sai tài khoản hoặc mật khẩu");
            exit;
        } catch (Exception $e) {
            error_log("Database query error: " . $e->getMessage());
            header("Location: ../Views/LoginView.php?error=Đã xảy ra lỗi. Vui lòng thử lại sau.");
            exit;
        }
    }
}
?>

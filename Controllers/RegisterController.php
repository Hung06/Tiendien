<?php
include '../Models/LoginModel.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register'])) {
        $name = $_POST['nameForm'];
        $email = $_POST['emailForm'];
        $password = $_POST['passwordForm'];
        $role = 'user'; // Vai trò mặc định là "user"
        $mkh = $_POST['mkhForm']; // Nhận giá trị MKH từ form đăng ký

        // Giá trị mặc định
        $SoDienBanDau = 0;
        $SoDienCuoi = 0;
        $SoTienCanDong = 0;
        $SoDienTieuThu = 0;
        $TrangThaiDongTien = 'Chưa thanh toán';

        // Kiểm tra người dùng đã tồn tại chưa
        $stmt = $db->prepare("SELECT * FROM Users WHERE TenUser = ? OR Email = ? OR MKH = ?");
        $stmt->execute([$name, $email,$mkh]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            header("Location: ../Views/RegisterView.php?error=MKh - Tài khoản - Email: đã tồn tại ");
            exit;
        } else {
            // Thêm người dùng mới vào cơ sở dữ liệu
            $stmt = $db->prepare("INSERT INTO Users (TenUser, Email, MatKhau, role, MKH, SoDienBanDau, SoDienCuoi, SoTienCanDong, TrangThaiDongTien, SoDienTieuThu) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$name, $email, $password, $role, $mkh, $SoDienBanDau, $SoDienCuoi, $SoTienCanDong, $TrangThaiDongTien, $SoDienTieuThu])) { // Không mã hóa mật khẩu
                header("Location: ../Views/LoginView.php?success=Đăng ký thành công. Vui lòng đăng nhập");
                exit;
            } else {
                header("Location: ../Views/RegisterView.php?error=Có lỗi xảy ra, vui lòng thử lại");
                exit;
            }
        }
    }
}
?>

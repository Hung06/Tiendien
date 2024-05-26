<?php
session_start();
require_once '../Controllers/DSController.php';

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: ./LoginView.php');
    exit();
}

// Create an instance of the controller
$controller = new DSController();

// Check if the form is submitted for payment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay'])) {
    $email = $_SESSION['email'];
    $controller->markAsPaid($email);
}

// Fetch user data
$user = $controller->getUserByEmail($_SESSION['email']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán</title>
    <link rel="stylesheet" href="http://localhost/Tiendien/Views/DienView.css">
</head>
<body>
    <menu class="menu">
        <a href="../Views/DienView.php" class="Tinhtien menu-a">Tính tiền điện</a>
        <a href="../Views/ThanhToanView.php" class="menu-a">Thanh Toán</a>
        <?php if ($_SESSION['role'] == 'admin'): ?>
            <a href="../Views/DSView.php" class="DSKH menu-a">Danh Sách khách hàng</a>
            <a href="../Views/SetupView.php" class="setup menu-a">Cài đặt</a>
        <?php endif; ?>
        <a href="../Views/LoginView.php" class="DX menu-a">Đăng Xuất</a>
    </menu>

    <?php
    if (!empty($user)) {
        echo "<table border='1'>
                <tr>
                    <th>Tên khách hàng</th>
                    <th>MKH</th>
                    <th>Số điện ban đầu</th>
                    <th>Số điện cuối</th>
                    <th>Số điện tiêu thụ</th>
                    <th>Tiền điện</th>
                    <th>Trạng thái đóng</th>
                    <th>Hành động</th>
                </tr>
                <tr>
                    <form method='POST' action='ThanhToanView.php'>
                        <td>{$user['TenUser']}</td>
                        <td>{$user['MKH']}</td>
                        <td>{$user['SoDienBanDau']}</td>
                        <td>{$user['SoDienCuoi']}</td>
                        <td>{$user['SoDienTieuThu']}</td>
                        <td>{$user['SoTienCanDong']}</td>
                        <td>{$user['TrangThaiDongTien']}</td>
                        <td>";
        if ($user['TrangThaiDongTien'] !== 'Đã thanh toán') {
            echo "<button type='submit' name='pay'>Thanh toán</button>";
        } else {
            echo "Đã thanh toán";
        }
        echo "</td>
                    </form>
                  </tr>";
        echo "</table>";
    } else {
        echo "Không tìm thấy thông tin người dùng.";
    }
    ?>
</body>
</html>

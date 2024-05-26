<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['IsLogin']) || $_SESSION['IsLogin'] !== true) {
    header("Location: ../Views/LoginView.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tính tiền điện</title>
    <link rel="stylesheet" href="http://localhost/Tiendien/Views/DienView.css">
</head>
<body>
    <menu class="menu">
        <a href="#" class="Tinhtien menu-a">Tính tiền điện</a>
        <?php if ($_SESSION['role'] == 'user'): ?>
            <a href="../Views/ThanhToanView.php" class="menu-a">Thanh Toán</a>
        <?php endif; ?>
        <?php if ($_SESSION['role'] == 'admin'): ?>
            <a href="../Views/DSView.php" class="DSKH menu-a">Danh Sách khách hàng</a>
            <a href="../Views/SetupView.php" class="setup menu-a">Cài đặt</a>
        <?php endif; ?>
        <a href="../Views/LoginView.php" class="DX menu-a">Đăng Xuất</a>
    </menu>
    <h1 style="font-size: 50px;">Tính tiền điện</h1>
    <div class="home">
        <?php if(isset($errorMessage)): ?>
            <p style="color: red;"><?php echo $errorMessage; ?></p>
        <?php endif; ?>
        <form action="../Controllers/DienController.php" method="post">
            <label for="kwh">Tổng điện năng tiêu thụ (kWh):</label>
            <input type="number" id="kwh" name="kwh" required>
            <input type="submit" value="Tính">
        </form>
    </div>
    <?php if(isset($data)): ?>
        <h2>Kết quả</h2>
        <table>
            <tr>
                <th>ĐƠN GIÁ (đồng/kWh)</th>
                <th>SẢN LƯỢNG (kWh)</th>
                <th>THÀNH TIỀN (đồng)</th>
            </tr>
            <?php foreach ($data as $row): ?>
                <tr>
                    <td><?php echo number_format($row[0]); ?></td>
                    <td><?php echo number_format($row[1]); ?></td>
                    <td><?php echo number_format($row[0] * $row[1]); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <h2>Thành tiền</h2>
        <p>Tiền điện chưa thuế: <?php echo number_format($total_cost); ?> đồng</p>
        <p>Thuế GTGT (8%) tiền điện: <?php echo number_format($vat); ?> đồng</p>
        <h1>Tổng cộng tiền thanh toán (đồng): <?php echo number_format($total_payment); ?> đồng</h1>
    <?php endif; ?>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="http://localhost/Tiendien/Views/DienView.css">
</head>
<body>
    <menu class="menu">
        <a href="./DienView.php" class="Tinhtien menu-a">Tính tiền điện</a>
        <a href="#" class="DSKH menu-a">Danh Sách khách hàng</a>
        <a href="../Views/SetupView.php" class="setup menu-a">Cài đặt</a>
        <a href="./LoginView.php" class="DX menu-a">Đăng Xuất</a>
    </menu>
    <?php
    // Include the controller to fetch data
    require_once '../Controllers/DSController.php';

    // Display error message if any
    if (!empty($errorMessage)) {
        echo "<div style='color: red; font-weight: bold;'>{$errorMessage}</div>";
    }

    // Display the users and their electricity costs
    if (!empty($users)) {
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
                </tr>";
        foreach ($users as $user) {
            echo "<tr>
                    <form method='POST' action='DSView.php'>
                        <td>{$user['TenUser']}</td>
                        <td>{$user['MKH']}</td>
                        <td>{$user['SoDienBanDau']}</td>
                        <td><input type='number' name='SoDienCuoi' value='{$user['SoDienCuoi']}' required></td>
                        <td>{$user['SoDienTieuThu']}</td>
                        <td>{$user['SoTienCanDong']}</td>
                        <td>{$user['TrangThaiDongTien']}</td>
                        <td>
                            <input type='hidden' name='Email' value='{$user['Email']}'>
                            <button type='submit' name='update'>Chỉnh sửa</button>
                        </td>
                    </form>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "No users found with updated electricity costs.";
    }
    ?>
</body>
</html>

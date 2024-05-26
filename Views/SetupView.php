<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Electricity Rates</title>
    <link rel="stylesheet" href="http://localhost/Tiendien/Views/DienView.css">
</head>
<body>
    <menu class="menu">
        <a href="./DienView.php" class="Tinhtien menu-a">Tính tiền điện</a>
        <a href="./DSView.php" class="DSKH menu-a">Danh Sách khách hàng</a>
        <a href="./SetupView.php" class="setup menu-a">Cài đặt</a>
        <a href="./LoginView.php" class="DX menu-a">Đăng Xuất</a>
    </menu>

    <h1>Cài đặt giá điện</h1>

    <?php
    require_once '../Controllers/SetupController.php';

    $controller = new SetupController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $rates = $_POST['rates'];
        try {
            $controller->updateElectricityRates($rates);
            $successMessage = "Cập nhật thành công";
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
        }
    }

    $rates = $controller->getElectricityRates();
    ?>

    <?php if (isset($successMessage)): ?>
        <p style="color: green;"><?php echo $successMessage; ?></p>
    <?php endif; ?>
    <?php if (isset($errorMessage)): ?>
        <p style="color: red;"><?php echo $errorMessage; ?></p>
    <?php endif; ?>

    <form method="post" action="SetupView.php">
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Rate</th>
                <th>Limit (kWh)</th>
            </tr>
            <?php if (!empty($rates)): ?>
                <?php foreach ($rates as $rate): ?>
                    <tr>
                       
                    <td><?php echo $rate['id']; ?></td>
                        <td>
                            <input type="number" step="0.01" name="rates[<?php echo $rate['id']; ?>]" value="<?php echo $rate['rate']; ?>" required>
                        </td>
                        <td><?php echo $rate['limit_kwh']; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No rates found.</td>
                </tr>
            <?php endif; ?>
        </table>
        <button type="submit">Cập nhật</button>
    </form>
</body>
</html>

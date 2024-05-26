<?php
require_once './Database/Database.php';
require_once 'DienModel.php';

class DSModel {
    public function connect() {
        return Database::getConnection();
    }

    public function getUsers() {
        $conn = $this->connect();
        $sql = "SELECT Email, TenUser, MKH, SoDienBanDau, SoDienCuoi, (SoDienCuoi - SoDienBanDau) AS SoDienTieuThu, SoTienCanDong, TrangThaiDongTien FROM Users WHERE role='user'";
        $stmt = $conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateElectricityCostForUsers() {
        $conn = $this->connect();
        $query = "SELECT Email, SoDienBanDau, SoDienCuoi FROM Users";
        $stmt = $conn->query($query);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($users as $user) {
            $email = $user['Email'];
            $kwh = $user['SoDienCuoi'] - $user['SoDienBanDau'];

            $data = DienModel::calculateElectricityCost($kwh);
            $total_cost = DienModel::calculateTotalCost($data);
            $vat = DienModel::calculateVAT($total_cost);
            $total_payment = DienModel::calculateTotalPayment($total_cost, $vat);

            $updateQuery = "UPDATE Users SET SoTienCanDong = :SoTienCanDong, SoDienTieuThu = :SoDienTieuThu WHERE Email = :Email";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->execute(['SoTienCanDong' => $total_payment, 'SoDienTieuThu' => $kwh, 'Email' => $email]);
        }
    }

    public function updateSoDienCuoi($email, $newSoDienCuoi) {
        $conn = $this->connect();
        
        // Fetch the current SoDienCuoi and SoDienBanDau
        $query = "SELECT SoDienBanDau, SoDienCuoi FROM Users WHERE Email = :Email";
        $stmt = $conn->prepare($query);
        $stmt->execute(['Email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user && $newSoDienCuoi > $user['SoDienBanDau']) {
            $currentSoDienCuoi = $user['SoDienCuoi'];
            $newSoDienBanDau = $currentSoDienCuoi;
            $kwh = $newSoDienCuoi - $newSoDienBanDau;
    
            $data = DienModel::calculateElectricityCost($kwh);
            $total_cost = DienModel::calculateTotalCost($data);
            $vat = DienModel::calculateVAT($total_cost);
            $total_payment = DienModel::calculateTotalPayment($total_cost, $vat);
    
            $updateQuery = "UPDATE Users SET SoDienBanDau = :SoDienBanDau, SoDienCuoi = :SoDienCuoi, SoTienCanDong = :SoTienCanDong, SoDienTieuThu = :SoDienTieuThu, TrangThaiDongTien = 'Chưa thanh toán' WHERE Email = :Email";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->execute([
                'SoDienBanDau' => $newSoDienBanDau,
                'SoDienCuoi' => $newSoDienCuoi,
                'SoTienCanDong' => $total_payment,
                'SoDienTieuThu' => $kwh,
                'Email' => $email
            ]);
        }
    }
    
    public function getUserByEmail($email) {
        $conn = $this->connect();
        $sql = "SELECT Email, TenUser, MKH, SoDienBanDau, SoDienCuoi, (SoDienCuoi - SoDienBanDau) AS SoDienTieuThu, SoTienCanDong, TrangThaiDongTien FROM Users WHERE Email = :Email";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['Email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function markAsPaid($email) {
        $conn = $this->connect();
        $updateQuery = "UPDATE Users SET TrangThaiDongTien = 'Đã thanh toán' WHERE Email = :Email";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->execute(['Email' => $email]);
    }
}
?>

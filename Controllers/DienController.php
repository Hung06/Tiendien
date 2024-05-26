<?php
include './Models/DienModel.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['kwh'])) {
        $kwh = intval($_POST['kwh']);
        if ($kwh <= 0) {
            $errorMessage = "Tổng điện năng tiêu thụ phải là số dương lớn hơn 0.";
            include '../Views/DienView.php';
            exit;
        } else {
            $data = DienModel::calculateElectricityCost($kwh);
            $total_cost = DienModel::calculateTotalCost($data);
            $vat = DienModel::calculateVAT($total_cost);
            $total_payment = DienModel::calculateTotalPayment($total_cost, $vat);
            include '../Views/DienView.php';
            exit;
        }
    }
}
?>

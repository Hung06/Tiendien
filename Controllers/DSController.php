<?php
require_once './Models/DSModel.php';

class DSController {
    private $model;
    public $errorMessage = '';

    public function __construct() {
        $this->model = new DSModel();
    }

    public function updateElectricityCostForUsers() {
        $this->model->updateElectricityCostForUsers();
    }

    public function getUsers() {
        return $this->model->getUsers();
    }

    public function updateSoDienCuoi($email, $newSoDienCuoi) {
        $conn = $this->model->connect();
        $query = "SELECT SoDienCuoi, SoDienBanDau FROM Users WHERE Email = :Email";
        $stmt = $conn->prepare($query);
        $stmt->execute(['Email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user) {
            // Kiểm tra nếu số điện cuối mới là một số hợp lệ và lớn hơn 0
            if (!is_numeric($newSoDienCuoi) || floatval($newSoDienCuoi) <= 0) {
                $this->errorMessage = "Số điện cuối phải là một số dương lớn hơn 0.";
                return;
            }
    
            // Kiểm tra nếu số điện cuối mới lớn hơn số điện ban đầu và số điện cuối hiện tại
            if ($newSoDienCuoi > $user['SoDienBanDau'] && $newSoDienCuoi > $user['SoDienCuoi']) {
                // Nếu số điện cuối mới khác với số điện cuối hiện tại, tiến hành cập nhật
                if ($newSoDienCuoi != $user['SoDienCuoi']) {
                    $this->model->updateSoDienCuoi($email, $newSoDienCuoi, $user['SoDienCuoi']);
                } else {
                    $this->errorMessage = "Số điện cuối phải khác với số điện cuối hiện tại.";
                }
            } else {
                $this->errorMessage = "Số điện cuối phải lớn hơn số điện ban đầu và số điện cuối hiện tại.";
            }
        }
    }
    
    
    
    public function getUserByEmail($email) {
        return $this->model->getUserByEmail($email);
    }

    public function markAsPaid($email) {
        return $this->model->markAsPaid($email);
    }
}

// Create an instance of the controller
$controller = new DSController();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $email = $_POST['Email'];
    $newSoDienCuoi = intval($_POST['SoDienCuoi']);
    $controller->updateSoDienCuoi($email, $newSoDienCuoi);
}

// Update electricity costs for all users
$controller->updateElectricityCostForUsers();

// Fetch updated user data
$users = $controller->getUsers();
$errorMessage = $controller->errorMessage;
?>

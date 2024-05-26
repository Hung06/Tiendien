<?php
require_once '../Database/Database.php';
session_start();

if (!isset($_SESSION["IsLogin"])) {
    $_SESSION["IsLogin"] = false;

}

try {
    $db = Database::getConnection();
    // Thực hiện các thao tác khác với cơ sở dữ liệu nếu cần thiết
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    // Ghi log lỗi
    error_log($e->getMessage());
    exit;
}
?>

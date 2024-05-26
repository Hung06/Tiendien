<?php
require_once './Database/Database.php';

class SetupModel {
    public function connect() {
        return Database::getConnection();
    }

    public function getElectricityRates() {
        $conn = $this->connect();
        $query = "SELECT * FROM ElectricityRates";
        $stmt = $conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateElectricityRate($id, $rate) {
        $conn = $this->connect();
        $query = "UPDATE ElectricityRates SET rate = :rate WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->execute(['rate' => $rate, 'id' => $id]);
    }
}
?>

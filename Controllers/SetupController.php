<?php
require_once './Models/SetupModel.php';

class SetupController {
    private $model;

    public function __construct() {
        $this->model = new SetupModel();
    }

    public function getElectricityRates() {
        return $this->model->getElectricityRates();
    }

    public function updateElectricityRates($rates) {
        // Validate rates
        foreach ($rates as $id => $rate) {

            // Check if rate is numeric, positive, and not zero
            if (!is_numeric($rate) || floatval($rate) <= 0) {
                throw new Exception("Giá điện phải là số dương > 0.");
            }
        }

        // Validate specific conditions for all 6 rates
        $previousRate = 0;
        foreach ($rates as $id => $rate) {
            if ($previousRate >= $rate) {
                throw new Exception("Số điện bậc trước phải nhỏ hơn bậc sau.");
            }
            $previousRate = $rate;
        }

        // Update rates
        foreach ($rates as $id => $rate) {
            $this->model->updateElectricityRate($id, $rate);
        }
    }
}
?>

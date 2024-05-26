<?php
require_once './Database/Database.php';


class DienModel {
    private static function getTiersFromDB() {
        $db = Database::getConnection();
        
        $tiers = array();
        $query = "SELECT rate, limit_kwh FROM ElectricityRates ORDER BY id ASC";
        $stmt = $db->query($query);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tiers[] = array($row['rate'], $row['limit_kwh']);
        }

        return $tiers;
    }

    public static function calculateElectricityCost($kwh) {
        $tiers = self::getTiersFromDB();

        $data = array();
        $remaining_kwh = $kwh;

        foreach ($tiers as $tier) {
            $tier_rate = $tier[0];
            $tier_limit = $tier[1];

            if ($tier_limit == 0 || $remaining_kwh <= $tier_limit) {
                $data[] = array($tier_rate, $remaining_kwh);
                break;
            } else {
                $data[] = array($tier_rate, $tier_limit);
                $remaining_kwh -= $tier_limit;
            }
        }

        return $data;
    }

    public static function calculateTotalCost($data) {
        $total_cost = 0;
        foreach ($data as $row) {
            $total_cost += $row[0] * $row[1];
        }
        return $total_cost;
    }

    public static function calculateVAT($total_cost) {
        return $total_cost * 0.08;
    }

    public static function calculateTotalPayment($total_cost, $vat) {
        return $total_cost + $vat;
    }
}
?>

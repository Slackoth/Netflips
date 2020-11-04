<?php
namespace app\models;

use app\core\Application;
use app\core\Model;

class PaymentModel extends Model {
    public function tablename() {
        return "payment";
    }

    public function fields() {
        return ["user_id", "initiation_date", "expiration_date"];
    }

    public function createPaymentSubscription($userId, $subsId, $subsType) {
        $sql = "SELECT create_payment_subscription(?, ?, ?);";
        $stmt = Application::getInstance()->db::$pdo->prepare($sql);

        $stmt->execute([$userId, $subsId, $subsType]);
    }
}
?>
<?php 
namespace app\models;

use app\core\Application;
use app\core\Model;
use PDO;

class SubscriptionModel extends Model {
    public function tablename() {
        return "subscription";
    }

    public function fields() {
        return ["type_id", "state_id", "plan_id", "total_cost"];
    }

    public function createSubscription($typeId) {
        $planModel = new PlanModel();
        $plan = $planModel->getAll();
        $planId = +$plan[0]["id"];
        $totalCost = +$plan[0]["cost"];

        switch ($typeId) {
            case 2:
                $totalCost = $totalCost * 6 - ($totalCost * 6 * 0.20);
                break;
            
            case 3:
                $totalCost = $totalCost * 12 - ($totalCost * 12 * 0.20);
            
            default:
                $totalCost = $totalCost;
                break;
        }

        return [
            "type_id" => $typeId,
            "state_id" => 1,
            "plan_id" => $planId,
            "total_cost" => $totalCost
        ];
    }

    public function save($data) {
        $tablename = $this->tablename();
        $fields = $this->fields();
        $params = array_map(fn($field) => ":$field", $fields);
        $sql = "INSERT INTO $tablename(" . implode(",", $fields) . ") 
            VALUES(". implode(",", $params) .") RETURNING id, type_id;";
        $stmt =  Application::getInstance()->db::$pdo->prepare($sql);

        foreach($data as $key => $value) 
            $stmt->bindValue(":$key", $value);

        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}
?>
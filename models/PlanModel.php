<?php
namespace app\models;

use app\core\Model;

class PlanModel extends Model {
    public function tablename() {
        return "plan";
    }

    public function fields() {
        return ["name", "description", "cost"];
    }
}
?>
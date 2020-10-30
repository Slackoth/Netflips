<?php
namespace app\models;

use app\core\Model;

class TypeModel extends Model {
    public function tablename() {
        return  "type";
    }

    public function fields() {
        return ["id","name"];
    }

    public function getCostByType($types, $cost) {
        $costs = [];

        foreach($types as $type) {
            switch($type["name"]) {
                case "semestral":
                    $costs[] = $cost * 6.0 * 0.8;
                    break;

                case "anual":
                    $costs[] = $cost * 12.0 * 0.8;
                    break;
                
                case "mensual": 
                default:
                    $costs[] = $cost * 1.0;
                    break;
            }
        }

        return $costs;
    }

    
}
?>
<?php
namespace app\models;

use app\core\Application;
use app\core\Model;
use \PDO;

class UserModel extends Model {
    public function tablename() {
        return "user";
    }

    public function fields() {
        return ["firstname", "lastname", "email", 
        "birthdate", "password"];
    }

    public function save($data) {
        $tablename = $this->tablename();
        $fields = $this->fields();
        $params = array_map(fn($field) => ":$field", $fields);
        $sql = "INSERT INTO $tablename(" . implode(",", $fields) . ") 
            VALUES(". implode(",", $params) .") RETURNING id, firstname, lastname;";
        $stmt =  Application::getInstance()->db::$pdo->prepare($sql);

        foreach($data as $key => $value) 
            $stmt->bindValue(":$key", $value);

        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }


}
?>
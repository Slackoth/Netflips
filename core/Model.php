<?php 
namespace app\core;

use \PDO;

abstract class Model {
    abstract public function tablename();
    abstract public function fields();

    public function save($data) {
        $tablename = $this->tablename();
        $fields = $this->fields();
        $params = array_map(fn($field) => ":$field", $fields);
        $sql = "INSERT INTO $tablename(" . implode(",", $fields) . ") 
            VALUES(". implode(",", $params) .")";
        $stmt =  Application::getInstance()->db::$pdo->prepare($sql);

        foreach($data as $key => $value) 
            $stmt->bindValue(":$key", $value);

        $stmt->execute();
        return true;
    }

    public function getAll($params = [], $conditionFields = []) {
        $tablename = $this->tablename();
        $fields = empty($params) ? "*" : implode(",", $params);
        $where = "";

        if(!empty($conditionFields)) {
            $where = "WHERE " . Application::getInstance()->db->createAndOrSyntax($conditionFields);
        }
        
        $sql = "SELECT $fields FROM $tablename $where;";
        $stmt = Application::getInstance()->db::$pdo->prepare($sql);

        foreach($conditionFields as $key => $value)
            $stmt->bindValue(":$key", $value);

        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //$json = json_encode($results);
        //return $json;
        return $results;
    }

    public function findOne($conditionFields, $params = []) { //$conditions = [db_field => value_to_search]
        $tablename = $this->tablename();
        $fields = empty($params) ? "*" : implode(",", $params);
        // $keys = array_keys($conditionFields);
        // $conditions = array_map(fn($key) => "$key = :$key", $keys);
        // $where = implode(" AND ", $conditions);
        $where = Application::getInstance()->db->createAndOrSyntax($conditionFields);
        $sql = "SELECT $fields FROM $tablename WHERE $where;";

        $stmt = Application::getInstance()->db::$pdo->prepare($sql);

        foreach($conditionFields as $key => $value)
            $stmt->bindValue(":$key", $value);

        $stmt->execute();

        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        return $results;
    }
}
?>
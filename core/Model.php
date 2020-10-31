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

    public function getAll($params = []) {
        $tablename = $this->tablename();
        $fields = empty($params) ? "*" : implode(",", $params);
        $sql = "SELECT $fields FROM $tablename;";
        $stmt = Application::getInstance()->db::$pdo->prepare($sql);

        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //$json = json_encode($results);
        //return $json;
        return $results;
    }
}
?>
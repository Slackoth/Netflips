<?php 
namespace app\core;

use \PDO;

class Database {
    public static $pdo;

    public function __construct($config) {
        $dsn = $config["dsn"] ?? "";
        $user = $config["user"] ?? "";
        $passwd = $config["passwd"] ?? "";
        self::$pdo = new PDO($dsn, $user, $passwd);
        //Throw exceptions
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function findOne($tablename, $conditionFields, $params = []) {
        $fields = empty($params) ? "*" : implode(",", $params);
        $keys = array_keys($conditionFields);
        $conditions = array_map(fn($key) => "$key = :$key", $keys);
        $where = implode("AND ", $conditions);
        $sql = "SELECT $fields FROM $tablename WHERE $where;";
        $stmt = Application::getInstance()->db::$pdo->prepare($sql);

        foreach($conditionFields as $key => $value)
            $stmt->bindValue(":$key", $value);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}
?>
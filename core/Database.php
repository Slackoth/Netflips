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
        // $keys = array_keys($conditionFields);
        // $conditions = array_map(fn($key) => "$key = :$key", $keys);
        // $where = implode(" AND ", $conditions);
        $where = $this->createAndOrSyntax($conditionFields);
        $sql = "SELECT $fields FROM $tablename WHERE $where;";
        $stmt = $this::$pdo->prepare($sql);

        foreach($conditionFields as $key => $value)
            $stmt->bindValue(":$key", $value);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function createAndOrSyntax($conditionFields, $andOr = true) {
        $logicalOperator = $andOr === true ? "AND" : "OR";
        $keys = array_keys($conditionFields);
        $conditions = array_map(fn($key) => "$key = :$key", $keys);
        $where = implode(" $logicalOperator ", $conditions);

        return $where;
    }

    public function getClients() {
        $sql = 'SELECT u.firstname , u.lastname, p.initiation_date, 
        p.expiration_date, p2.name as plan, t.name as type, s.total_cost 
        FROM user u INNER JOIN payment p
        ON u.id  = p.user_id INNER JOIN payment_subscription ps 
        ON p.id = ps.payment_id INNER JOIN subscription s
        ON s.id = ps.subscription_id INNER JOIN plan p2 
        ON s.plan_id = p2.id INNER JOIN type t
        ON s.type_id = t.id WHERE p.expiration_date >= :current';
        $stmt = $this::$pdo->prepare($sql);

        $stmt->bindValue(":current", date("y-m-d"));
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
}
?>
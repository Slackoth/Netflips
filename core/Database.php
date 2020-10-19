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
}
?>
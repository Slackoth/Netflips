<?php

use app\core\Application;
use app\controllers\AuthController;
use Dotenv\Dotenv;

require_once __DIR__ . "/../vendor/autoload.php";

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    "db" => [
        "dsn" => $_ENV["DB_DSN"],
        "user" => $_ENV["DB_USER"],
        "passwd" => $_ENV["DB_PASSWORD"]
    ]
];

$app = Application::getInstance(dirname(__DIR__), $config);

$app->router->get("/register", [AuthController::class, "registerGet"]);

$app->run();
?>
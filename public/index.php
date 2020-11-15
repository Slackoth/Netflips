<?php

use app\controllers\AdminClientsController;
use app\core\Application;
use app\controllers\AuthController;
use app\controllers\HomeController;
use Dotenv\Dotenv;

require_once __DIR__ . "/../vendor/autoload.php";
//include __DIR__ . "/../resources/js";

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

$app->router->get("/login", [AuthController::class, "login"]);
$app->router->post("/login", [AuthController::class, "login"]);


$app->router->get("/selectplan", [AuthController::class, "selectPlanGet"]);
$app->router->post("/selectplan", [AuthController::class, "selectPlanPost"]);
$app->router->get("/register", [AuthController::class, "registerGet"]);
$app->router->post("/register", [AuthController::class, "registerPost"]);

$app->router->get("/home", [HomeController::class, "homeGet"]);

$app->router->get("/clients", [AdminClientsController::class, "clientsGet"]);

$app->run();
?>
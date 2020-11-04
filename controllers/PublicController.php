<?php
namespace app\controllers;

use app\core\Application;
use app\core\Controller;

class PublicController extends Controller {
    public function __construct() {
        if(!$this->isLoggedIn()) {
            Application::getInstance()->response->redirect("/login");
            exit;
        }
    }
}
?>
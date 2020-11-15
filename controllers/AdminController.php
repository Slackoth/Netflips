<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Application;
use app\core\exceptions\ForbiddenAccessException;

class AdminController extends Controller {
    public function __construct() {
        if(!$this->isLoggedIn()) {
            Application::getInstance()->response->redirect("/login");
            exit;
        }
        else if(!$this->isAdmin()) {
            Application::getInstance()->response->setStatusCode(403);
            throw new ForbiddenAccessException();
            exit;
        }
    }
}
?>
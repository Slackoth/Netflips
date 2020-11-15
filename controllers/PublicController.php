<?php
namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\exceptions\ForbiddenAccessException;

class PublicController extends Controller {
    public function __construct() {
        if(!$this->isLoggedIn()) {
            Application::getInstance()->response->redirect("/login");
            exit;
        }
        else if($this->isAdmin()) {
            throw new ForbiddenAccessException();
            exit;
        }
    }
}
?>
<?php
namespace app\core;

class Controller {
    public function render($view, $title, $layout, $params = []) {
        Application::getInstance()->view->setTitle($title);
        Application::getInstance()->view->setLayout($layout);
        return Application::getInstance()->view->renderView($view,$params);
    }

    public function isLoggedIn() {
        return isset($_SESSION["loggedIn"]);
    }

    public function isAdmin() {
        return isset($_SESSION["isAdmin"]);
    }
}
?>
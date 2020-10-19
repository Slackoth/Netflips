<?php
namespace app\core;

class Controller {
    public function render($view, $title, $layout, $params = []) {
        Application::getInstance()->view->setTitle($title);
        Application::getInstance()->view->setLayout($layout);
        Application::getInstance()->view->renderView($view,$params);
    }
}
?>
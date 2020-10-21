<?php 
namespace app\controllers;

use app\core\Controller;

class HomeController extends Controller {
    public function homeGet() {
        return $this->render("home", "Home", "main");
    }
}
?>
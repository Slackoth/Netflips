<?php 
namespace app\controllers;

use app\core\Controller;

class HomeController extends PublicController {
    public function __construct() {
        parent::__construct();
    }

    public function homeGet() {
        return $this->render("home", "Home", "main");
    }
}
?>
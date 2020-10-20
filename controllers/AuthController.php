<?php 
namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\core\Response;

class AuthController extends Controller {
    public function registerGet(Request $req, Response $res) {
        return $this->render("register", "Netflips", "auth");
    }
}
?>
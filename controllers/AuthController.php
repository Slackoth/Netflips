<?php 
namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\RegisterForm;

class AuthController extends Controller {
    public function registerGet(Request $req, Response $res) {
        $registerForm = new RegisterForm();

        return $this->render("register", "Netflips", "auth", [
            "formModel" => $registerForm
        ]);
    }

    public function registerPost(Request $req, Response $res) {
        $registerForm = new RegisterForm();

        $registerForm->loadData($req->getRequestBody());
        if($registerForm->validateData()) {
            Application::getInstance()->session->setFlashMessage("success",
                "La registración ha sido exitosa.");
            Application::getInstance()->response->redirect("/home");
        }
        else {
            return $this->render("register", "Netflips", "auth", [
                "formModel" => $registerForm
            ]);
        }

    }
}
?>
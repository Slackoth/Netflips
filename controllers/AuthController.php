<?php 
namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\PlanModel;
use app\models\RegisterForm;
use app\models\SubscriptionModel;
use app\models\TypeModel;
use app\models\UserModel;

class AuthController extends Controller {
    public function registerGet(Request $req, Response $res) {
        $registerForm = new RegisterForm();
        $res->setStatusCode(200);
        return $this->render("register", "Netflips", "auth", [
            "formModel" => $registerForm
        ]);
    }

    public function registerPost(Request $req, Response $res) {
        $registerForm = new RegisterForm();
        $reqBody = $registerForm->addBirthdateKey($req->getRequestBody());
        
        $registerForm->loadData($reqBody);
        
        if($registerForm->validateData()) {
            //unset confirmPassword here?
            unset($reqBody["confirmPassword"]);
            $reqBody["password"] = $registerForm->hashPassword($reqBody["password"]);
            //string to int: $int = +$stringNum;
            $typeId = +Application::getInstance()->session->getAttribute("type");
            $subsModel = new SubscriptionModel();
            $userModel = new UserModel();
            $subscription = $subsModel->createSubscription($typeId);

            echo "<pre>" . var_dump($reqBody) . "</pre>";

            Application::getInstance()->session->unsetAttribute("type");

            try {
                $subsModel->save($subscription);
                $userModel->save($reqBody);
            } catch (\PDOException $e) {
                throw $e;
            }
            
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

    public function selectPlanGet(Request $req, Response $res) {
        $typeModel = new TypeModel();
        $planModel = new PlanModel();
        //$json = $typeModel->getAll(["name"]);
        $types = $typeModel->getAll(["name"]);
        $plans = $planModel->getAll(["name", "description", "cost"]);
        $costs = $typeModel->getCostByType($types, $plans[0]["cost"]);

        $res->setStatusCode(200);
        return $this->render("select_plan", "Select plan", "auth", [
            "types" => $types,
            "plans" => $plans,
            "costs" => $costs
        ]);
    }

    public function selectPlanPost(Request $req, Response $res) {
        $type = $req->getRequestBody()["type"];
        Application::getInstance()->session->setAttribute("type",$type);
        $res->setStatusCode(200);
        return "Ok";
    }
}
?>
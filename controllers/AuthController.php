<?php 
namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\PaymentModel;
use app\models\PlanModel;
use app\models\RegisterForm;
use app\models\SubscriptionModel;
use app\models\TypeModel;
use app\models\UserModel;

class AuthController extends Controller {
    public function __construct() {
        if($this->isLoggedIn()) {
            Application::getInstance()->response->redirect("/home");
            exit;
        }
    }

    public function registerGet(Request $req, Response $res) {
        if(!isset($_SESSION["type"])) {
            Application::getInstance()->response->redirect("/selectplan");
            exit;
        }
        
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
            $subsModel = new SubscriptionModel();
            $userModel = new UserModel();
            $paymentModel = new PaymentModel();
            //unset confirmPassword here?
            unset($reqBody["confirmPassword"]);

            $reqBody["password"] = $registerForm->hashPassword($reqBody["password"]);
            //string to int: $int = +$stringNum;
            $typeId = +Application::getInstance()->session->getAttribute("type");
            $subscription = $subsModel->createSubscription($typeId);

            Application::getInstance()->session->unsetAttribute("type");

            try {
                $subsInfo = $subsModel->save($subscription);
                $userInfo = $userModel->save($reqBody);
                $paymentModel->createPaymentSubscription(+$userInfo["id"], 
                    +$subsInfo["id"], +$subsInfo["type_id"]);
                
            } catch (\PDOException $e) {
                throw $e;
            }
            
            Application::getInstance()->session->setFlashMessage("success",
                "La registración ha sido exitosa.");
            Application::getInstance()->session->setUser($userInfo);
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
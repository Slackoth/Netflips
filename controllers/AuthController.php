<?php 
namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\core\Session;
use app\models\PaymentModel;
use app\models\PlanModel;
use app\models\RegisterForm;
use app\models\SubscriptionModel;
use app\models\TypeModel;
use app\models\UserModel;
use app\models\LoginForm;
use http\Client\Curl\User;

class AuthController extends Controller {
    public function __construct() {
        if($this->isLoggedIn()) {
            error_log('jeje');
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
                //var_dump("userinfo", $userInfo);
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

    public function login(Request $req, Response $res) {

        $loginForm = new LoginForm();

        if ($req->getMethod() === 'post') {
            echo var_dump($req->getRequestBody()['email']);
            $loginForm->loadData($req->getRequestBody());
            echo var_dump($loginForm->email);
            if ( $loginForm->login()) {
                Application::$app->response->redirect('/');
                return;
            }

            Application::getInstance()->response->redirect("/home");
        }
        //$this->setLayout('auth');
        return $this->render('login','Log In', 'auth', [
            'formModel' => $loginForm
        ]);
    }


    public function logout(Request $request, Response $response){
        error_log('data');

        //session_start();

        // Destruir todas las variables de sesión.
        $_SESSION = array();


        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }


        // Finalmente, destruir la sesión.
        session_destroy();
        Application::getInstance()->response->redirect("/login");

    }
}
?>
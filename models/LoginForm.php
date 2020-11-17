<?php


namespace app\models;
use app\core\Database;
use app\core\form\FormModel;
use app\core\Model;

use app\core\Application;




class LoginForm  extends  FormModel {
    private $tries;

    public function __construct() {
        if(!isset($_SESSION["login_tries"]))
            Application::getInstance()->session->setAttribute("login_tries", 0);
        else
            $this->tries = Application::getInstance()->session->getAttribute("login_tries");
    }

    public function tablename() {
        return "user";
    }

    public function fields() {
        return ["email", "password"];
    }

    public string $email = '';
    public string $password = '';

    public function rules()
    {
        return [
            // 'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            // 'password' => [self::RULE_REQUIRED, self::RULE_INVALID_LOGIN,
            //     ],
        ];
    }

    public function labels()
    {
        return [
            "email" => "Correo Electrónico",
            "password" => "Contraseña"
        ];
    }

    public function login() {
        $now = time();

        if($this->tries >= 3) {
            Application::getInstance()->session->setAttribute("waiting_time", $now + 300);
            Application::getInstance()->session->setAttribute("login_tries", 0);
            
            return false;
        }
        else if(isset($_SESSION["waiting_time"]) && $_SESSION["waiting_time"] > $now) {
            $_SESSION['errors'] = 
                array("Ha superado el límite de intentos para ingresar a su cuenta. Espere 5 minutos.");
            
            Application::getInstance()->response->redirect("login");
            exit;
        }

        $user = Application::getInstance()->db->findOne( 'user',['email' => $this->email], ['password']);
        
        $pswd_substr=substr($user['password'],0,strlen($user['password'])-1);

        if (empty($this->password) or empty($this->email)){
            $_SESSION['errors'] = array("Por favor complete los campos correctamente");
            return false;
        }
        if (!$user) {
            $this->tries++;
            Application::getInstance()->session->setAttribute("login_tries", $this->tries);
            $_SESSION['errors'] = array("Usuario / Contraseña Incorrecta");

            return false;
        }
        if (!password_verify($this->password, $pswd_substr)) {
            $this->tries++;
            Application::getInstance()->session->setAttribute("login_tries", $this->tries);
            $_SESSION['errors'] = array("Usuario / Contraseña Incorrecta");
            
            return false;
        }

        $userinfo = Application::getInstance()->db->findOne('user',['email' => $this->email], ['id', 'firstname', 'lastname', "is_admin"]);
        
        Application::getInstance()->session->setUser($userinfo);

        return true;
    }


}
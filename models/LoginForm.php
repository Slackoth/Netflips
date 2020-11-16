<?php


namespace app\models;
use app\core\Database;
use app\core\form\FormModel;
use app\core\Model;

use app\core\Application;




class LoginForm  extends  FormModel
{

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
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED, self::RULE_INVALID_LOGIN,
                ],
        ];
    }

    public function labels()
    {
        return [
            "email" => "Correo Electrónico",
            "password" => "Contraseña"
        ];
    }

    public function login()
    {

        $user = Application::getInstance()->db->findOne( 'user',['email' => $this->email], ['password']);
        //echo var_dump('user',$user['password']);
        //echo  var_dump('data',$this->password);
        //echo var_dump(substr($user['password'],0,strlen($user['password'])-1));
        $pswd_substr=substr($user['password'],0,strlen($user['password'])-1);
        if (empty($this->password) or empty($this->email)){
            $_SESSION['errors'] = array("Por favor complete los campos correctamente");
            return false;
        }
        if (!$user) {
            $_SESSION['errors'] = array("Este Usuario es Inexistente");
            return false;
        }
        if (!password_verify($this->password, $pswd_substr)) {
            //$this->addError('password', 'Password is incorrect');
            $message="Usuario / Contraseña equivocado";
            //echo "<script>alert('$message');</script>";
            $_SESSION['errors'] = array("Usuario / Contraseña Incorrecta");
            return false;
        }
        $userinfo=Application::getInstance()->db->findOne('user',['email' => $this->email], ['id', 'firstname', 'lastname', "is_admin"]);
        //var_dump("userinfo: : : ", $userinfo);
        Application::getInstance()->session->setUser($userinfo);
                //return Application::->login($user);

        return true;
    }


}
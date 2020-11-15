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
            'password' => [self::RULE_REQUIRED],
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

        if (!$user) {
            //$this->addError('email', 'User does not exist with this email address');
            return false;
        }
        if (!password_verify($this->password, $pswd_substr)) {
            //$this->addError('password', 'Password is incorrect');
            var_dump('Password is incorrect');
            return false;
        }
        $userinfo=Application::getInstance()->db->findOne('user',['email' => $this->email], ['id', 'firstname', 'lastname']);
        //var_dump("userinfo: : : ", $userinfo);
        Application::getInstance()->session->setUser($userinfo);
                //return Application::->login($user);
    }


}
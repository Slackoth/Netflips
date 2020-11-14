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
        $user = Database::findOne( 'user',['email' => $this->email]);
        echo var_dump($user);
        if (!$user) {
            $this->addError('email', 'User does not exist with this email address');
            return false;
        }
        if (!password_verify($this->password, $user->password)) {
            $this->addError('password', 'Password is incorrect');
            return false;
        }

        return Application::$app->login($user);
    }


}
<?php
namespace app\models;

use app\core\form\FormModel;

class RegisterForm extends FormModel {
    public $firstname = "";
    public $lastname = "";
    public $email = "";
    public $password = "";
    public $confirmPassword = "";
    public $birthdate = "";
    // public $cardNumber = "";
    // public $verificationCode = "";

    public function rules() {
        return [
            "firstname" => [self::RULE_REQUIRED],
            "lastname" => [self::RULE_REQUIRED],
            "email" => [self::RULE_REQUIRED, self::RULE_EMAIL
                // [
                //     self::RULE_UNIQUE,
                //     "class" => self::class
                // ]
            ],
            "password" => [self::RULE_REQUIRED, 
                [
                    self::RULE_MIN_LEN, 
                    "min" => 8
                ], 
                [
                    self::RULE_MAX_LEN,
                    "max" => 24
                ]
            ],
            "confirmPassword" => [self::RULE_REQUIRED, 
                [
                    self::RULE_MATCH,
                    "match" => "password"
                ]
            ],
            "birthdate" => [self::RULE_VALID_DATE]
        ];
    }

    public function labels() {
        return [
            "firstname" => "Nombres",
            "lastname" => "Apellidos",
            "email" => "Correo",
            "password" => "Contraseña",
            "confirmPassword" => "Confirmar contraseña",
            "birthdate" => "Fecha de nacimiento"
        ];
    }

    public function hashPassword($passwd) {
        /*
        hrtime() -> Get the system's high resolution time
        md5() -> Calculate the md5 hash of a string
        */
        $randomChar = substr(md5(hrtime()[0]), rand(0, 31), 1);
        return password_hash($passwd, PASSWORD_DEFAULT) . "$randomChar";
    }

    public function addBirthdateKey($body) {
        //$birthdate = $body["day"] . "/" . $body["month"] . "/" . $body["year"];
        $birthdate = $body["year"] . "-" . $body["month"] . "-" . $body["day"];
        $birthdate = ["birthdate" => $birthdate];
        
        unset($body["day"]);
        unset($body["month"]);
        unset($body["year"]);
        
        return array_slice($body, 0, 3, true) + $birthdate + 
            array_slice($body, 3, count($body) - 1, true);
    }
}
?>
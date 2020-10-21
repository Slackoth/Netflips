<?php
namespace app\models;

use app\core\form\FormModel;

class RegisterForm extends FormModel {
    public $firstname = "";
    public $lastname = "";
    public $email = "";
    public $password = "";
    public $confirmPassword = "";
    public $country = "";
    // public $cardNumber = "";
    // public $verificationCode = "";
    // public $month = "";
    // public $year = "";

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
            "country" => [self::RULE_REQUIRED],
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
            ]
        ];
    }

    public function labels() {
        return [
            "firstname" => "Firstname",
            "lastname" => "Lastname",
            "email" => "Email",
            "country" => "Country",
            "password" => "Password",
            "confirmPassword" => "Confirm Password",
        ];
    }
}
?>
<?php 
namespace app\core\form;

use app\core\Application;

abstract class FormModel {
    public const RULE_REQUIRED = "required";
    public const RULE_EMAIL = "email";
    public const RULE_MIN_LEN = "min";
    public const RULE_MAX_LEN = "max";
    public const RULE_MATCH = "match";
    public const RULE_UNIQUE = "unique";
    public const RULE_VALID_DATE = "valid_date";
    /*public const RULE_INVALID_LOGIN="required";*/
    public const RULE_NEXT_CHAR_REPEATED = "next_char_repeated";
    public const RULE_UPPERCASE_CHAR = "capital_char";
    public const RULE_LOWERCASE_CHAR = "lowercase_char";
    public const RULE_NUMBER_CHAR = "number_char";
    public const RULE_SPECIAL_CHAR = "special_char";
    public $errors = [];

    abstract public function rules();

    abstract public function labels();

    public function loadData($data) {
        foreach($data as $key => $value)
            if(property_exists($this, $key))
                $this->{$key} = $value;
    }

    public function getLabel($attr) {
        return $this->labels()[$attr] ?? $attr;
    }

    private function errorMessages() {
        return [
            self::RULE_REQUIRED => "Este campo es obligatorio.",
            self::RULE_EMAIL => "Este campo tiene que ser un correo válido.",
            self::RULE_MIN_LEN => "El largo de este campo debe ser de {min} carácteres mínimo.",
            self::RULE_MAX_LEN => "El largo de este campo debe ser de {max} carácteres máximo.",
            self::RULE_MATCH => "Este campo debe ser igual al campo de {match}.",
            self::RULE_UNIQUE => "El valor ingresado en {field} ya existe.",
            self::RULE_VALID_DATE => "La fecha introducida no es válida.",
            /*self::RULE_INVALID_LOGIN => "Contraseña / Usuario Incorrecto.",*/
            self::RULE_NEXT_CHAR_REPEATED => "Este campo no permite repetición de carácteres consecutivos.",
            self::RULE_UPPERCASE_CHAR => "El minímo de mayúsculas debe ser de {min}.",
            self::RULE_LOWERCASE_CHAR => "El minímo de minúsculas debe ser de {min}.",
            self::RULE_NUMBER_CHAR => "El minímo de números debe ser de {min}.",
            self::RULE_SPECIAL_CHAR => "El minímo de carácteres especiales debe ser de {min}."
        ]; 
    }

    private function addErrorForRule($attr, $rule, $params = []) {
        $message = $this->errorMessages()[$rule] ?? "";

        foreach($params as $key => $value) 
            $message = str_replace("{{$key}}", $value, $message);

        $this->errors[$attr][] = $message;
    }

    public function hasError($attr) {
        return $this->errors[$attr] ?? false;
    }

    public function getFirstError($attr) {
        return $this->errors[$attr][0] ?? "";
    }

    public function validateData() {
        foreach($this->rules() as $attr => $rules) {
            $value = $this->{$attr};

            foreach($rules as $rule) {
                $ruleName = $rule;

                if(!is_string($ruleName)) 
                    $ruleName = $rule[0];
                
                $this->applyRules($attr, $value, $rule, $ruleName);
            }
        }

        return empty($this->errors);
    }

    private function applyRules($attr, $value, $rule, $ruleName) {
        switch($ruleName) {
            case self::RULE_REQUIRED:
                $value ? true : $this->addErrorForRule($attr, self::RULE_REQUIRED);
                break;
            
            case self::RULE_EMAIL:
                filter_var($value, FILTER_VALIDATE_EMAIL) ? true : $this->addErrorForRule($attr, self::RULE_EMAIL);
                break;

            case self::RULE_MIN_LEN:
                (strlen($value) >= $rule["min"]) ? true : $this->addErrorForRule($attr, self::RULE_MIN_LEN, $rule);
                break;
            
            case self::RULE_MAX_LEN:
                (strlen($value) <= $rule["max"]) ? true : $this->addErrorForRule($attr, self::RULE_MAX_LEN, $rule);
                break;
            
            case self::RULE_MATCH:
                if($value !== $this->{$rule["match"]}) {
                    $rule["match"] = $this->getLabel($rule["match"]);
                    $this->addErrorForRule($attr, self::RULE_MATCH, $rule);
                }
                break;
            
            case self::RULE_VALID_DATE:
                $date = explode("-", $value);
                checkdate($date[1], $date[2], $date[0]) ? true : $this->addErrorForRule($attr, self::RULE_VALID_DATE);
                break;

            case self::RULE_UNIQUE:
                $tablename = $rule["tablename"];
                $result = Application::getInstance()->db->findOne($tablename, [$attr => $value], [$attr]);

                empty($result) ? true : $this->addErrorForRule($attr, self::RULE_UNIQUE, ["field" => $this->getLabel($attr)]);
                break;

            // case self::RULE_INVALID_LOGIN:
            //     $this->addErrorForRule($attr, self::RULE_INVALID_LOGIN, ["field"=> $this->getLabel($attr)]);
            //     break;
            
            case self::RULE_NEXT_CHAR_REPEATED:
                for($i = 0; $i < strlen($value); $i++)
                    if($value[$i] === $value[$i + 1]) {
                        $this->addErrorForRule($attr, self::RULE_NEXT_CHAR_REPEATED);
                        break;
                    }
                break;
            
            case self::RULE_UPPERCASE_CHAR:
            case self::RULE_LOWERCASE_CHAR:
            case self::RULE_SPECIAL_CHAR:
                $this->checkString($ruleName, $value, $rule["min"]) === true ? true : $this->addErrorForRule($attr, $ruleName, $rule);
                
        }
    }

    private function checkString($ruleName, $str, $min) {
        $count = 0;

        for($i = 0; $i < strlen($str); $i++) {
            switch($ruleName) {
                case self::RULE_UPPERCASE_CHAR:
                    $count += (ctype_upper($str[$i]) === true ? 1 : 0);
                    break;
                
                case self::RULE_LOWERCASE_CHAR:
                    $count += (ctype_lower($str[$i]) === true ? 1 : 0);
                    break;
                
                case self::RULE_NUMBER_CHAR:
                    $count += (is_numeric($str[$i]) === true ? 1 : 0);
                    break;
                
                case self::RULE_SPECIAL_CHAR:
                    $count += (preg_match('/[^a-zA-Z\d]/', $str[$i]) === 1 ? 1 : 0);
                    break;
            }
        }

        if($count >= $min)
            return true;
        else
            return false;
    }
}
?>
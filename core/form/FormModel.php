<?php 
namespace app\core\form;

abstract class FormModel {
    public const RULE_REQUIRED = "required";
    public const RULE_EMAIL = "email";
    public const RULE_MIN_LEN = "min";
    public const RULE_MAX_LEN = "max";
    public const RULE_MATCH = "match";
    public const RULE_UNIQUE = "unique";
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
            self::RULE_REQUIRED => "This field is required.",
            self::RULE_EMAIL => "This field must be a valid email address.",
            self::RULE_MIN_LEN => "Min length of this field must be {min} characters minimum.",
            self::RULE_MAX_LEN => "Max length of this field must be {max} characters maximum.",
            self::RULE_MATCH => "This field must be the same as the {match} field.",
            self::RULE_UNIQUE => "This {field} already exists."
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
                    
                    // case self::RULE_UNIQUE:
                    //     $className = $rule["class"];
                    //     $uniqueAttr = $rule["attribute"] ?? $attr;
                    //     $tableName = $className::tableName();

                    //     $statement = Application::$APP->db->prepare("SELECT * FROM $tableName 
                    //     WHERE $uniqueAttr = :$uniqueAttr");
                        
                    //     $statement->bindValue(":$uniqueAttr", $value);
                    //     $statement->execute();
                    //     $record = $statement->fetchObject();

                    //     ($record == NULL) ? true : $this->addErrorForRule($attr, self::RULE_UNIQUE, ["field" => $this->getLabel($attribute)]);
                    //     break;
                }
            }
        }

        return empty($this->errors);
    }


}
?>
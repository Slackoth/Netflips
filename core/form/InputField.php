<?php
namespace app\core\form;

class InputField extends BaseField{
    public const TYPE_TEXT = "text";
    public const TYPE_PASSWORD = "password";
    public const TYPE_NUMBER = "number";
    public $type;

    public function __construct($formModel, $attr) {
        $this->type = self::TYPE_TEXT;
        parent::__construct($formModel, $attr);
    }

    public function setType($type) {
        switch($type) {
            case "password":
                $this->type = self::TYPE_PASSWORD;
                break;
            case "number":
                $this->type = self::TYPE_NUMBER;
                break;
            case "text":
            default:
                $this->type = self::TYPE_TEXT;
                break;
        }

        return $this;
    }
    
    public function renderInput() {
        return sprintf('<input type="%s" name="%s" value="%s" class="form-control %s">',
            $this->type,
            $this->attribute,
            $this->formModel->{$this->attribute},
            $this->formModel->hasError($this->attribute) ? "is-invalid" : ""
        );
    }
}
?>
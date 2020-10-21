<?php
namespace app\core\form;

abstract class BaseField {
    public $formModel;
    public $attribute;

    public function __construct($formModel, $attribute) {
        $this->formModel = $formModel;
        $this->attribute = $attribute;
    }

    public abstract function renderInput(); 

    public function __toString() {
        return sprintf(
            '<div class="form-group">
                <label for="%s">%s</label>
                %s
                <div class="invalid-feedback">
                    %s
                </div>
            </div>',
            $this->attribute, 
            $this->formModel->getLabel($this->attribute),
            $this->renderInput(),
            $this->formModel->getFirstError($this->attribute)
        );
    }
}
?>
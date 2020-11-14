<?php
namespace app\core\form;

abstract class BaseField {
    public $formModel;
    public $attribute;

    public function __construct($formModel, $attribute) {
       // echo var_dump('gola');
        //echo var_dump($attribute);
        $this->formModel = $formModel;
        $this->attribute = $attribute;
        //echo var_dump($this->attribute);
        //echo var_dump('gola2');
        //echo var_dump($this->formModel);
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
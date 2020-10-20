<?php
namespace app\core\form;

abstract class BaseField {
    public $model;
    public $attribute;

    public function __construct($model, $attribute) {
        $this->model = $model;
        $this->attribute = $attribute;
    }

    public abstract function renderInput(); 

    // public function __toString() {
    //     return sprintf(
    //         '<div class="form-group">
    //             <label for="%s">%s</label>
    //             %s
    //             <div class="invalid-feedback">
    //                 %s
    //             </div>
    //         </div>',
    //         $this->attribute, 
    //         $this->model->getLabel($this->attribute),
    //         $this->renderInput(),
    //         $this->model->getFirstError($this->attribute)
    //     );
    // }
}
?>
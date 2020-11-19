<?php
namespace app\core\form;

class SelectBirthdateField extends BaseField {
    private $days = [];
    private $months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
        "Julio", "Agosto","Septiembre", "Octubre", "Noviembre", "Diciembre"];
    private $years = [];
    
    public function __construct($formModel, $attr) {
        $this->days = range(1, 31);
        $this->years = range(2002, 1900);
        parent::__construct($formModel, $attr);
    }

    public function renderInput() {
        return sprintf(
            '<div class="col">
                <div class="form-group">
                    <select class="custom-select" name="day">
                    %s
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <select class="custom-select" name="month">
                        %s
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <select class="custom-select" name="year">
                        %s
                    </select>
                </div>
            </div>',
            $this->renderDaysMonths($this->days),
            $this->renderDaysMonths($this->months),
            $this->renderYears($this->years)
        );
    }

    private function renderDaysMonths($options) {
        $select = "";
        $index = 1;
        
        foreach($options as $key => $value) {
            $select .= $index == 1 ? '<option selected value="' . $index . '">' . $value . "</option>" 
                : '<option value="' . $index . '">' . $value . '</option>';
            $index++;
        }

        return $select;
    }

    private function renderYears($options) {
        $select = "";
        
        foreach($options as $key => $value) 
            $select .= '<option>' . $value . '</option>';
            
        return $select;
    }

    public function __toString() {
        return sprintf(
            '<label>%s</label>
            <div class="row">
                    %s
            </div>
            <div class="text-danger">
                <small>%s</small>
            </div>
            ',
            $this->formModel->getLabel($this->attribute),
            $this->renderInput(),
            $this->formModel->getFirstError($this->attribute)
        );
    }
}
?>
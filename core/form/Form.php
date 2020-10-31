<?php 
namespace app\core\form;

class Form {
    public static function begin($attributes = []) {
        $action = $attributes["action"] ?? "";
        $method = $attributes["method"] ?? "post";
        
        switch($method) {
            case "post":
            case "get":
                echo sprintf('<form action="%s" method="%s">', $action, $method);
                break;
            default:
                echo "Only POST or GET method allowed.";
                return NULL;
        }
        
        return new Form();
    }

    public static function end() {
        return "</form>";
    }

    public function inputField($model, $attr) {
        return new InputField($model, $attr);
    }

    public function selectBirthdateField($model, $attr) {
        return new SelectBirthdateField($model, $attr);
    }
}
?>
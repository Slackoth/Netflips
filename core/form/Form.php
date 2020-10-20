<?php 
namespace app\core\form;

class Form {
    public static function begin($attributes = []) {
        $action = $attributes["action"] ?? "";
        $method = $attributes["method"] ?? "post";
        
        switch($method) {
            case "post":
            case "get":
                echo sprintf('<form action="%s" method="%s>', $action, $method);
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
}
?>
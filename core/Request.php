<?php 
namespace app\core;

class Request {
    public function getMethod() {
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }

    public function getPath() {
        $path = $_SERVER["REQUEST_URI"] ?? "/";
        $pos = strpos($path, "?");

        return $pos === false ? $path : substr($path, 0, $pos);
    }

    public function getRequestBody() {
        $body = [];

        switch($this->getMethod()) {
            case "get": 
                foreach($_GET as $key => $value) 
                    $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                echo print_r($body);
                break; 

            case "post":
                foreach($_POST as $key => $value) 
                    $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS); 
                break;
        }
        
        return $body;
    }
}
?>
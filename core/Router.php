<?php 
namespace app\core;

class Router {
    private $routes = [];
    public $request;
    public $response;

    public function __construct(Request $req, Response $res) {
        $this->request = $req;
        $this->response = $res;
    }

    public function get($path, $callback) {
        $this->routes["get"][$path] = $callback;
    }

    public function post($path, $callback) {
        $this->routes["post"][$path] = $callback;
    }

    public function resolve() {
        $method = $this->request->getMethod();
        $path = $this->request->getPath();
        $callback = $this->routes[$method][$path] ?? false;

        if(!$callback) {
            echo "Not found!";
            return false;
        }

        else if(is_string($callback))
            return Application::getInstance()->view->renderView($callback);

        else if(is_array($callback)) {
            //$callback[0] holds a class name.
            $controller = new $callback[0]();
            $callback[0] = $controller;
            Application::getInstance()->controller = $controller;

            /*Executes the method in [0] of the class in [1]
            callback -> [
                0 => app\controllers\GivenController,
                1 => FunctionName to be executed
            ]
            */
            echo call_user_func($callback, $this->request, $this->response);
        }
    }
}
?>
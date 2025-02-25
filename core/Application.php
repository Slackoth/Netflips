<?php 
namespace app\core;

use app\core\exceptions\DatabaseException;
use app\core\exceptions\ForbiddenAccessException;
use app\core\exceptions\NotFoundException;
use Exception;
use PDOException;

class Application {
    public static string $root_dir;
    public static ?Application $instance = NULL;
    public View $view;
    public Database $db;
    public Router $router;
    public Request $request;
    public Response $response;
    public Controller $controller;
    public Session $session;

    public function __construct($rootPath, $config) {
        self::$root_dir = $rootPath;
        $this->view = new View();
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->session = new Session();
        
        try {
            $this->db = new Database($config["db"]);
        } 
        catch (Exception $e) {
            echo $e;
        }
    }

    public static function getInstance($rootPath = "", $config = []) {
        if(self::$instance == NULL)
            self::$instance = new Application($rootPath, $config);

        return self::$instance; 
    }

    public function run() {
        try {
            echo $this->router->resolve();
        }
        catch(ForbiddenAccessException $e) {
            $this->view->setTitle($e->getCode());
            $this->view->setLayout("_error");
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView("error",  [
                "exception" => $e
            ]);
        }
        catch(NotFoundException $e) {
            $this->view->setTitle($e->getCode());
            $this->view->setLayout("_error");
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView("error",  [
                "exception" => $e
            ]);
        }
        catch(Exception $e) {
            $this->view->setTitle($e->getCode());
            $this->view->setLayout("_error");
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView("error",  [
                "exception" => $e
            ]);
        }
    }
}
?>
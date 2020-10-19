<?php 
namespace app\core;

class Application {
    public static string $root_dir;
    public static ?Application $instance = NULL;
    public View $view;
    public Database $db;

    public function __construct($rootPath, $config) {
        self::$root_dir = $rootPath;
        $this->view = new View();
        
        try {
            $this->db = new Database($config["db"]);
        } catch (\Exception $e) {
            echo $e;
        }
    }

    public static function getInstance($rootPath = "", $config = []) {
        if(self::$instance == NULL)
            self::$instance = new Application($rootPath, $config);

        return self::$instance; 
    }
}
?>
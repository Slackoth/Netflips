<?php 
namespace app\core;

class Application {
    public static string $root_dir;
    public static Application $app;

    public function __construct($rootPath, $config) {
        self::$root_dir = $rootPath;
    }
}
?>
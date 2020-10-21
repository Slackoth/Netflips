<?php 
namespace app\core;

class View {
    public string $title = "";
    public string $layout = "main";

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setLayout($layout) {
        $this->layout = $layout;
    }

    public function renderView($view, $params = []) {
        $viewContent = $this->viewContent($view, $params);
        $layoutContent = $this->layoutContent();

        return str_replace("{{content}}", $viewContent, $layoutContent);
    }

    protected function viewContent($view, $params) {
        foreach($params as $key => $value)
            $$key = $value;
        
        ob_start();
        include_once Application::$root_dir . "/views/$view.php";

        return ob_get_clean();
    }

    protected function layoutContent() {
        ob_start();
        include_once Application::$root_dir . "/views/layouts/" . $this->layout . ".php";

        return ob_get_clean();
    }
}
?>
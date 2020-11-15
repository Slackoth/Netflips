<?php 
namespace app\controllers;

use app\core\Application;
use app\core\Request;
use app\core\Response;
use app\models\UserModel;

class AdminClientsController extends AdminController {
    public function __construct() {
        parent::__construct();
    }

    public function clientsGet(Request $req, Response $res) {
        $results = Application::getInstance()->db->getClients();
        
        $res->setStatusCode(200);
        return $this->render("admin_clients", "Clients", "admin", [
            "clients" => $results
        ]);
    }
}
?>
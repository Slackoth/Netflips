<?php
namespace app\models;

use app\core\Model;

class UserModel extends Model {
    public function tablename() {
        return "user";
    }

    public function fields() {
        return ["firstname", "lastname", "email", 
        "birthdate", "password"];
    }
}
?>
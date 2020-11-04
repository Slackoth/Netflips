<?php
namespace app\core;

use Dotenv\Parser\Value;

class Session {
    protected const FLASH_KEY = "flash_messages";

    public function __construct() {
        session_start();
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];

        foreach($flashMessages as $key => &$flashMessage) 
            $flashMessage["remove"] = true;

        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    public function setFlashMessage($key, $message) {
        $_SESSION[self::FLASH_KEY][$key] = [
            "remove" => false,
            "message" => $message
        ];
    }

    public function getFlashMessage($key) {
        return $_SESSION[self::FLASH_KEY][$key]["message"] ?? false;
    }

    public function setAttribute($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function unsetAttribute($key) {
        unset($_SESSION[$key]);
    }

    public function getAttribute($key) {
        return $_SESSION[$key] ?? false;
    }

    public function setUser($user) {
        foreach($user as $key => $value) 
            $this->setAttribute("user_$key", $value);
        
        $this->setAttribute("loggedIn", true);
    }

    public function __destruct() {
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];

        foreach($flashMessages as $key => &$flashMessage) 
            if($flashMessage["remove"])
                unset($flashMessages[$key]);
        
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
}
?>
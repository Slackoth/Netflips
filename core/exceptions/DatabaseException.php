<?php
namespace app\core\exceptions;

use \Exception;
use PDOException;

class DatabaseException extends PDOException {
    public function __construct($message=null, $code=null) {
        $this->message = $message;
        $this->code = 500;
    }
}
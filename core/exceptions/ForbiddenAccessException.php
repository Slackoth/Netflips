<?php
namespace app\core\exceptions;

use \Exception;

class ForbiddenAccessException extends Exception {
    protected $code = 403;
    protected $message = "Forbidden Access";

    public function __construct() {}
}
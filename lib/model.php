<?php
namespace model;
require_once(ROOT_DIR . "/config/settings.php");

class Model {
    protected static function getDb() {
        $options = array(\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ, \PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING);
        return new \PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $options);
    }
}

class InvalidModelException extends \Exception {
    protected $message = 'You input invalid model';
}

?>

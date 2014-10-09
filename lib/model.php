<?php
namespace model;

class Model {
    /*
        Base model class that instanciate model and has db utilities.
    */
    public function __construct($model_id){
        $data = $this->get($model_id);
        foreach ($data as $k => $v) {
            $this->{$k} = $v;
        }
    }

    public static function getList () {
        $table = static::$table;
        $query = static::getDb()->prepare("SELECT * FROM $table");
        $query->execute();
        return $query->fetchAll();
    }

    public static function get($model_id) {
        $table = static::$table;
        $pk = static::$pk;
        $query = static::getDb()->prepare("SELECT * FROM $table WHERE $pk = $model_id");
        $query->execute();
        $data = $query->fetch();
        if (empty($data)) {
            throw new ModelNotFoundException();
        }
        return $data;
    }

    public function delete() {
        $table = static::$table;
        $pk = static::$pk;
        $pk_v = $this->$pk;
        $query = self::getDb()->prepare("DELETE FROM $table WHERE $pk = $pk_v;");
        $query->execute();
        return true;
    }

    public static function getDBConfig() {
        return json_decode(file_get_contents(ROOT_DIR . '/config/settings.json'), true)["db"];
    }

    protected static function getDb() {
        $options = array(\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ, \PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING);
        $dbConfig = self::getDBConfig();
        return new \PDO($dbConfig["type"] . ':host=' . $dbConfig["host"] . ';dbname=' . $dbConfig["name"], $dbConfig["user"], $dbConfig["pass"], $options);
    }
}

class InvalidModelException extends \Exception {
    protected $message = "You input invalid model";
}

class ModelNotFoundException extends \Exception {
    protected $message = "Model queried does not exist";
}
?>

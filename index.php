<?php
define('ROOT_DIR', dirname(realpath(__FILE__)));
require_once(ROOT_DIR . "/lib/controller.php");
require_once(ROOT_DIR . "/lib/model.php");
require_once(ROOT_DIR . "/lib/router.php");
require_once(ROOT_DIR . "/lib/view.php");
$url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : null;
$method = strtolower($_SERVER['REQUEST_METHOD']);
$router = new Router();
$router->route($url, $method);
?>

<?php
class Router {
    /*
        This defines requests path routing to controllers' actions
    */
    private static $routes = array(
        '/user' => array('controller' => 'user', 'methods' => array('get' => array('action' => 'getUsersList'), 'post' => array('action' => 'createUser')), 'url_params' => array()),
        '/user/(\d+)' => array('controller' => 'user', 'methods' => array('get' => array('action' => 'getUser'), 'delete' => array('action' => 'deleteUser')), 'url_params' => array('user_id')),
        '/user/(\d+)/songs' => array('controller' => 'user', 'methods' => array('get' => array('action' => 'getUserSongs'), 'post' => array('action' => 'addUserSong')), 'url_params' => array('user_id')),
        '/user/(\d+)/songs/(\d+)' => array('controller' => 'user', 'methods' => array('delete' => array('action' => 'deleteUserSong')), 'url_params' => array('user_id', 'song_id')),
        // TODO implement song controller
        // '/song' => array('controller' => 'song', 'methods' => array('get' => array('action' => 'getSongsList'), 'post' => array('action' => 'createSong')), 'url_params' => array()),
        // '/song/(\d+)' => array('controller' => 'song', 'methods' => array('get' => array('action' => 'getSong'), 'delete' => array('action' => 'deleteSong')), 'url_params' => array('song_id')),
    );

    public function notFound() {
        require ROOT_DIR . '/controllers/error.php';
        $error = new Error();
        $error->notFound();
    }

    public function route($url, $method) {
        $url = parse_url($url);
        $path = preg_replace('/(\d+)/', '(\d+)', $url['path']);
        if (array_key_exists($path, static::$routes) && array_key_exists($method, static::$routes[$path]['methods'])) {
            $route = static::$routes[$path];
            require ROOT_DIR . '/controllers/' . $route['controller'] . '.php';
            $controller_class = ucfirst($route['controller']);
            $this->controller = new $controller_class();
            if (method_exists($this->controller, $route['methods'][$method]['action'])) {
                $params = array();
                if ($method == 'get') {
                    $params['params'] = isset($url['query']) ? $url['query'] : null;
                } elseif ($method == 'post') {
                    $params['params'] = $_POST;
                }
                if (preg_match_all('/\d+/', $url['path'], $matches)) {
                    $params = array_merge(array_combine($route['url_params'], $matches[0]), $params);
                }
                call_user_func_array(array($this->controller, $route['methods'][$method]['action']), $params);
            } else {
                $this->notFound();
            }
        } else {
            $this->notFound();
        }
    }
}
?>

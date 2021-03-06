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
        '/song' => array('controller' => 'song', 'methods' => array('get' => array('action' => 'getSongsList')), 'url_params' => array()),
        '/song/(\d+)' => array('controller' => 'song', 'methods' => array('get' => array('action' => 'getSong'),), 'url_params' => array('song_id')),
        //used for cross domain iframe messaging test
        '/test_main' => array('controller' => 'test', 'methods' => array('get' => array('action' => 'main')), 'url_params' => array()),
        '/test_iframe' => array('controller' => 'test', 'methods' => array('get' => array('action' => 'iframe')), 'url_params' => array()),
    );

    public function notFound() {
        require ROOT_DIR . '/controllers/error.php';
        $error = new Error();
        $error->notFound();
    }

    /**
     * Parse url and routes to proper action passing proper parameters
     * @param url url to parse
     * @param method http method (GET, POST, PUT, DELETE)
     */
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
                //parsing url path parameters
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

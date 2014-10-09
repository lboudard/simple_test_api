<?php
require_once(ROOT_DIR . '/lib/model/user.php');

class User extends Controller {
 
    public function getUsersList($params) {
        $this->view->renderText(json_encode(model\User::getList()));
    }

    public function createUser($params) {
        $this->view->renderText(json_encode(model\User::create($params)));
    }

    public function getUser($user_id, $params) {
        $this->view->renderText(json_encode(model\User::get($user_id)));
    }

    public function deleteUser($user_id) {
        $user = new model\User($user_id);
        $this->view->renderText(json_encode($user->delete()));
    }

    public function addUserSong($user_id, $params) {
        $user = new model\User($user_id);
        $this->view->renderText(json_encode($user->addSong($params['song_id'])));
    }

    public function deleteUserSong($user_id, $song_id) {
        $user = new model\User($user_id);
        $this->view->renderText(json_encode($user->deleteSong($song_id)));
    }

    public function getUserSongs($user_id) {
        $user = new model\User($user_id);
        $this->view->renderText(json_encode($user->getSongs()));
    }
}
?>

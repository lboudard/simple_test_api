<?php
require_once(ROOT_DIR . '/lib/model/song.php');

class Song extends Controller {

    public function getSongsList() {
        $this->view->renderText(json_encode(model\Song::getList()));
    }

    public function getSong($song_id, $params) {
        $this->view->renderText(json_encode(model\Song::get($song_id)));
    }
}
?>

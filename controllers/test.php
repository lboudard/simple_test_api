<?php

class Test extends Controller {
 
    public function main($params) {
        $this->view->render('test/main');
    }

    public function iframe($params) {
        $this->view->render('test/iframe');
    }
}
?>

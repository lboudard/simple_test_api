<?php

class Test extends Controller {
    public function __construct(){
        parent::__construct();
    }
 
    public function main($params) {
        $this->view->render('test/main');
    }

    public function iframe($params) {
        $this->view->render('test/iframe');
    }
}
?>

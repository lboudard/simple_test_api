<?php

class Error extends Controller {
    public function __construct(){
        parent::__construct();
    }
 
    public function notFound(){
        $this->view->render('errors/not_found');
    }
    //TODO more error management
}
?>

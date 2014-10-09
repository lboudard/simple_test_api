<?php

class Controller {
    /*
        Base model class tfor controllers.
    */
    protected $view;

    public function __construct() {
        $this->view = new View();
    }
}
?>

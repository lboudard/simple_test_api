<?php

class Controller {
    //TODO error management
    protected $view;

    public function __construct() {
        $this->view = new View();
    }
}
?>

<?php

class View {
    /*
        Simple class to render views
    */
    public function render($name) {
        require ROOT_DIR . '/views/header.php';
        require ROOT_DIR . '/views/' . $name .'.php';
        require ROOT_DIR . '/views/footer.php';
    }

    public function renderText($text) {
        echo $text;
    }
}
?>

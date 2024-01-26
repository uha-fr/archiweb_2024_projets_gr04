<?php

// à modifier

class BaseController {
    protected function view($view, $data = []) {
        extract($data);
        require_once "Views/" . $view . ".php";
    }

    protected function redirect($path) {
        header("Location: " . $path);
        exit();
    }
}

<?php

require_once 'AppController.php';

class DefaultController extends AppController {

    public function index() {
        //TODO
        $this->render('login', ['message' => "Hello world!"]);
    }

    public function statistics() {
        $this->render('statistics');
    }
}
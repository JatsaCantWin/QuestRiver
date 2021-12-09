<?php

require_once 'AppController.php';

class DefaultController extends AppController {

    public function index() {
        //TODO
        $this->render('login');
    }

    public function statistics() {
        die("statistics method");
        $this->render('statistics');
    }
}
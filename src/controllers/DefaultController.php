<?php

require_once 'AppController.php';

class DefaultController extends AppController {

    public function index() {
        if (isset($_COOKIE['sessionid']))
        {
            if (!$this->verifySession($this->getSessionID()))
                $this->render('login', ['messages' => ["Your session expired."]]);
            else
                $this->render('statistics', ['messages' => [$this->getCurrentUser()->getUsername()]]);
        }
        else
            $this->render('login');
    }

    public function statistics() {
        $this->index();
    }
}
<?php

require_once 'AppController.php';
require_once __DIR__.'/../controllers/SecurityController.php';
require_once __DIR__.'/../repository/SkillRepository.php';


class DefaultController extends AppController {

    private $messages = [];

    public function isLoggedIn()
    {
        if (!isset($_COOKIE['sessionid']))
            return false;
        if (is_null($this->getSessionID()))
        {
            $securityController = new SecurityController();
            $securityController->stopSession();
            $this->messages[] = 'Your session expired';
            return false;
        }
        return true;
    }

    public function index() {
        if (!$this->isLoggedIn())
            $this->render('login', ['messages' => $this->messages]);
        else
            $this->statistics();
    }

    public function statistics() {
        if ($this->isLoggedIn())
            $this->render('statistics');
        else
            $this->index();
    }

    public function quests() {
        if ($this->isLoggedIn())
            $this->render('quests');
        else
            $this->index();
    }
}
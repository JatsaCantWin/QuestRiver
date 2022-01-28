<?php

require_once 'AppController.php';
require_once __DIR__.'/../controllers/SecurityController.php';
require_once __DIR__.'/../repository/SkillRepository.php';


class DefaultController extends AppController {

    public function index() {
        if (isset($_COOKIE['sessionid']))
        {
            if (is_null($this->getSessionID()))
            {
                $securityController = new SecurityController();
                $securityController->stopSession();
                $this->render('login', ['messages' => ["Your session expired."]]);
            }
            else
            {
                $skillRepository = new SkillRepository();
                $this->render('statistics', ['skills' => $skillRepository->getUserSkills($this->getCurrentUser()), 'messages' => [$this->getCurrentUser()->getUsername()]]);
            }
        }
        else
            $this->render('login');
    }

    public function statistics() {
        $this->index();
    }
}
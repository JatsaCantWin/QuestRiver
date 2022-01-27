<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';

class SecurityController extends AppController
{
    public function login()
    {
        $userRepository = new UserRepository();

        if ($this->isGet())
        {
            return $this->render('login');
        }

        $email = $_POST["email"];
        $password = $_POST["password"];

        $user = $userRepository->getUser($email);

        if (!$user) {
            return $this->render('login', ['messages' => ["User with this e-mail doesn't exist."]]);
        }

        if ($user->getPassword() !== $password) {
            return $this->render('login', ['messages' => ["Wrong password"]]);
        }

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/statistics");
    }

    public function register()
    {

    }
}
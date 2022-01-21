<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';

class SecurityController extends AppController
{
    public function login()
    {
        $user = new User('brodvald@edwarf.eb', 'bombur#1', 'Brodvald');

        if ($this->isGet())
        {
            return $this->render('login');
        }

        $email = $_POST["email"];
        $password = $_POST["password"];

        if ($user->getEmail() !== $email) {
            return $this->render('login', ['messages' => ["User with this e-mail doesn't exist."]]);
        }

        if ($user->getPassword() !== $password) {
            return $this->render('login', ['messages' => ["Wrong password"]]);
        }

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/statistics");
    }
}
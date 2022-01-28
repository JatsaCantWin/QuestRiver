<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';

class SecurityController extends AppController
{
    public function startSession(User $user): void
    {
        $userRepository = new UserRepository();
        $userRepository->startSession($user);

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/statistics");
    }

    public function stopSession(): void
    {
        if (isset($_COOKIE['sessionid']))
        {
            $userRepository = new UserRepository();

            $userRepository->stopSession($_COOKIE['sessionid']);
            setcookie('sessionid', $_COOKIE['sessionid'], time() - 1);
        }
    }

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

        if (!password_verify($password, $user->getPassword()))
        {
            return $this->render('login', ['messages' => ["Wrong password"]]);
        }

        $this->startSession($user);
    }

    public function logout()
    {
        $this->stopSession();
        $this->render('login');
    }

    public function registrationValidateUser(User $user, &$messages): ?bool
    {
        $userRepository = new UserRepository();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $username = $user->getUsername();

        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $messages = ['Invalid e-mail address'];
            return false;
        }
        if ($userRepository->getUser($email) !== null)
        {
            $messages = ['User with this e-mail already exists'];
            return false;
        }
        if ($password === "")
        {
            $messages = ['Empty password'];
            return false;
        }
        if ($username === "")
        {
            $messages = ['Empty username'];
            return false;
        }

        return true;
    }

    public function register()
    {
        if (!$this->isPost())
        {
            $this->render('login');
            echo "<script>document.getElementById(\"registerModal\").style.display = \"flex\";</script>";
            return;
        }

        $userRepository = new UserRepository();
        $user = new User($_POST['registerEmail'], password_hash($_POST['registerPassword'], PASSWORD_DEFAULT), $_POST['registerUsername']);
        $messages = [];
        if (!($this->registrationValidateUser($user, $messages)))
        {
            $this->render('login', ['registerMessages' => $messages]);
            echo "<script>document.getElementById(\"registerModal\").style.display = \"flex\";</script>";
            return;
        }
        $userRepository->addUser($user);

        $this->startSession($user);
    }
}
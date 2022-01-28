<?php

class AppController {
    private $request;

    public function __construct(){
        $this->request = $_SERVER['REQUEST_METHOD'];
    }

    protected function isGet(): bool
    {
        return $this->request === 'GET';
    }

    protected function isPost(): bool
    {
        return $this->request === 'POST';
    }

    protected function isDelete(): bool
    {
        return $this->request === 'DELETE';
    }

    protected function getSessionID(): string
    {
        if (!isset($_COOKIE['sessionid']))
            return '';
        if (!$this->verifySession($_COOKIE['sessionid']))
            return '';

        setcookie('sessionid', $_COOKIE['sessionid'], time() + COOKIE_LIFETIME);
        return $_COOKIE['sessionid'];
    }

    protected function getCurrentUser(): ?User
    {
        $userRepository = new UserRepository();

        if (!isset($_COOKIE['sessionid']))
            return null;
        return $userRepository->getUserBySessionID($this->getSessionID());
    }

    protected function verifySession(string $sessionID): bool
    {
        $userRepository = new UserRepository();
        return $userRepository->isValidSession($sessionID);
    }

    protected function render(string $template = null, array $variables = []) {
        $templatePath = 'public/views/'.$template.'.php';
        $output = 'File not found';

        if (file_exists($templatePath)) {
            extract($variables);

            ob_start();
            include $templatePath;
            $output = ob_get_clean();
        }

        print $output;
    }
}
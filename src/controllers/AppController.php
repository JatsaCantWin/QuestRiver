<?php

class AppController {
    private $request;

    public function __construct(){
        $this->request = $_SERVER['REQUEST_METHOD'];
    }

    protected function isMethod(string $method): bool
    {
        return $this->request === $method;
    }

    protected function getSessionID(): ?string
    {
        if (!isset($_COOKIE['sessionid']))
            return '';
        if (!$this->verifySession($_COOKIE['sessionid']))
            return null;

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

    protected function fetchRequest(array $arguments, string $method, array &$input): int
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        if (!$this->isMethod($method))
            return 405;
        if ((!empty($arguments))&&($contentType !== "application/json"))
            return 400;
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);

        if (!isset($_SERVER["HTTP_SESSIONID"]))
            return 401;
        if (!$this->verifySession($_SERVER["HTTP_SESSIONID"]))
            return 401;
        foreach ($arguments as $argument)
            if (!isset($decoded[$argument]))
                return 401;

        foreach ($arguments as $argument)
            $input[$argument] = $decoded[$argument];
            //array_push($input, $argument, $decoded[$argument]);
        return 0;
    }
}
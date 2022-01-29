<?php

require_once 'AppController.php';

class UserController extends AppController
{
    public function fetchGetUser()
    {
        if (!$this->isGet())
            return http_response_code(405);

        if (!isset($_SERVER["HTTP_SESSIONID"]))
            return http_response_code(401);

        $sessionid = $_SERVER["HTTP_SESSIONID"];

        if (!$this->verifySession($sessionid))
        {
            return http_response_code(401);
        }

        $userRepository = new UserRepository();
        $user = $userRepository->getUserBySessionID($sessionid);

        $result = [];

        $result[] = ['email' => $user->getEmail(), 'username' => $user->getUsername()];

        header('Content-type: application/json');
        echo json_encode($result);
        return http_response_code(200);
    }

    public function fetchGetUserStats()
    {
        if (!$this->isGet())
            return http_response_code(405);

        if (!isset($_SERVER["HTTP_SESSIONID"]))
            return http_response_code(401);

        $sessionid = $_SERVER["HTTP_SESSIONID"];

        if (!$this->verifySession($sessionid))
        {
            return http_response_code(401);
        }

        $userRepository = new UserRepository();
        $user = $userRepository->getUserBySessionID($sessionid);
        $result = $userRepository->getUserStats($user);

        header('Content-type: application/json');
        echo json_encode($result);
        return http_response_code(200);
    }
}
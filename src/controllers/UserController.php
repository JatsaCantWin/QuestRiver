<?php

require_once 'AppController.php';

class UserController extends AppController
{
    public function fetchGetUser()
    {
        $input = [];
        $errorResponseCode = $this->fetchRequest([], "GET", $input);
        if ($errorResponseCode > 0)
            return http_response_code($errorResponseCode);

        $userRepository = new UserRepository();
        $user = $userRepository->getUserBySessionID($_SERVER["HTTP_SESSIONID"]);
        $result = [];
        $result[] = ['email' => $user->getEmail(), 'username' => $user->getUsername()];
        header('Content-type: application/json');
        echo json_encode($result);
        return http_response_code(200);
    }

    public function fetchGetUserStats()
    {
        $input = [];
        $errorResponseCode = $this->fetchRequest([], "GET", $input);
        if ($errorResponseCode > 0)
            return http_response_code($errorResponseCode);

        $userRepository = new UserRepository();
        $user = $userRepository->getUserBySessionID($_SERVER['HTTP_SESSIONID']);
        $result = $userRepository->getUserStats($user);
        header('Content-type: application/json');
        echo json_encode($result);
        return http_response_code(200);
    }

    public function fetchAdvanceAttribute()
    {
        $input = [];
        $errorResponseCode = $this->fetchRequest(['attributeName'], "POST", $input);
        if ($errorResponseCode > 0)
            return http_response_code($errorResponseCode);

        $userRepository = new UserRepository();
        $user = $userRepository->getUserBySessionID($_SERVER["HTTP_SESSIONID"]);
        $userRepository->advanceAttribute($user, $input['attributeName']);
        return http_response_code(200);
    }
}
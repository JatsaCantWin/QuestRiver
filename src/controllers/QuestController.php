<?php

include_once 'AppController.php';
include_once __DIR__.'/../repository/UserRepository.php';
include_once __DIR__.'/../repository/QuestRepository.php';

class QuestController extends AppController
{
    public function fetchCompleteQuest()
    {
        $input = [];
        $errorResponseCode = $this->fetchRequest(['questName'], "POST", $input);
        if ($errorResponseCode > 0)
            return http_response_code($errorResponseCode);

        $userRepository = new UserRepository();
        $questRespository = new QuestRepository();
        $user = $userRepository->getUserBySessionID($_SERVER['HTTP_SESSIONID']);
        $questRespository->finishUserQuest($user, $input['questName']);
        return http_response_code(200);
    }

    public function fetchAddQuest()
    {
        $input = [];
        $errorResponseCode = $this->fetchRequest(["questName"], "POST", $input);
        if ($errorResponseCode > 0)
            return http_response_code($errorResponseCode);

        $userRepository = new UserRepository();
        $questRepository = new QuestRepository();
        $user = $userRepository->getUserBySessionID($_SERVER["HTTP_SESSIONID"]);
        foreach ($questRepository->getUserQuests($user) as $quest)
            if ($quest->getQuestName() === $input["questName"])
                return http_response_code(409);
        $questRepository->addUserQuest($user, $input["questName"]);
        return http_response_code(201);
    }

    public function fetchDeleteQuest()
    {
        $input = [];
        $errorResponseCode = $this->fetchRequest(["questName"], "DELETE", $input);
        if ($errorResponseCode > 0)
            return http_response_code($errorResponseCode);

        $userRepository = new UserRepository();
        $questRepository = new QuestRepository();
        $user = $userRepository->getUserBySessionID($_SERVER['HTTP_SESSIONID']);
        $questRepository->deleteUserQuest($user, $input["questName"]);
        return http_response_code(200);
    }

    public function fetchGetQuests()
    {
        $input = [];
        $errorResponseCode = $this->fetchRequest([], "GET", $input);
        if ($errorResponseCode > 0)
            return http_response_code($errorResponseCode);

        $userRepository = new UserRepository();
        $questRepository = new QuestRepository();
        $user = $userRepository->getUserBySessionID($_SERVER['HTTP_SESSIONID']);
        $result = [];
        foreach ($questRepository->getUserQuests($user) as $quest)
            $result[] = ['questName' => $quest->getQuestName(), 'finished' => $quest->isFinished()];
        header('Content-type: application/json');
        echo json_encode($result);
        return http_response_code(200);
    }
}
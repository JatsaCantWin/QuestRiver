<?php

include_once 'AppController.php';
include_once __DIR__.'/../repository/UserRepository.php';
include_once __DIR__.'/../repository/SkillRepository.php';

class SkillController extends AppController
{
    public function fetchAdvanceSkill()
    {
        $input = [];
        $errorResponseCode = $this->fetchRequest(['skillname', 'lastpracticed'], "POST", $input);
        if ($errorResponseCode > 0)
            return http_response_code($errorResponseCode);

        $userRepository = new UserRepository();
        $user = $userRepository->getUserBySessionID($_SERVER['HTTP_SESSIONID']);
        $userRepository->addXP($user, 2);
        return http_response_code(200);
    }

    public function fetchAddSkill()
    {
        $input = [];
        $errorResponseCode = $this->fetchRequest(['skillname'], "POST", $input);
        if ($errorResponseCode > 0)
            return http_response_code($errorResponseCode);

        $userRepository = new UserRepository();
        $skillRepository = new SkillRepository();
        $user = $userRepository->getUserBySessionID($_SERVER["HTTP_SESSIONID"]);
        foreach ($skillRepository->getUserSkills($user) as $skill)
            if ($skill->getSkillName() === $input["skillname"])
                return http_response_code(409);
        $skillRepository->addUserSkill($user, $input["skillname"]);
        return http_response_code(201);
    }

    public function fetchDeleteSkill()
    {
        $input = [];
        $errorResponseCode = $this->fetchRequest(["skillname"], "DELETE", $input);
        if ($errorResponseCode > 0)
            return http_response_code($errorResponseCode);

        $userRepository = new UserRepository();
        $skillRepository = new SkillRepository();
        $user = $userRepository->getUserBySessionID($_SERVER['HTTP_SESSIONID']);
        $skillRepository->deleteUserSkill($user, $input["skillname"]);
        return http_response_code(200);
    }

    public function fetchGetSkill()
    {
        $input = [];
        $errorResponseCode = $this->fetchRequest([], "GET", $input);
        if ($errorResponseCode > 0)
            return http_response_code($errorResponseCode);

        $userRepository = new UserRepository();
        $skillRepository = new SkillRepository();
        $user = $userRepository->getUserBySessionID($_SERVER['HTTP_SESSIONID']);
        $result = [];
        foreach ($skillRepository->getUserSkills($user) as $skill)
            $result[] = ['skillName' => $skill->getSkillName(), 'lastPracticed' => $skill->getLastPracticed()];
        header('Content-type: application/json');
        echo json_encode($result);
        return http_response_code(200);
    }
}
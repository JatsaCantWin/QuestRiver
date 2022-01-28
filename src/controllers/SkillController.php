<?php

include_once 'AppController.php';
include_once __DIR__.'/../repository/UserRepository.php';
include_once __DIR__.'/../repository/SkillRepository.php';

class SkillController extends AppController
{
    public function fetchAddSkill()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if (!$this->isPost())
            return http_response_code(405);

        if ($contentType === "application/json")
        {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            if ((!isset($_SERVER["HTTP_SESSIONID"]))||(!isset($decoded['skillname'])))
                return http_response_code(401);

            $sessionid = $_SERVER["HTTP_SESSIONID"];

            if (!$this->verifySession($sessionid))
            {
                return http_response_code(401);
            }

            $userRepository = new UserRepository();
            $skillRepository = new SkillRepository();
            $user = $userRepository->getUserBySessionID($sessionid);

            foreach ($skillRepository->getUserSkills($user) as $skill)
                if ($skill->getSkillName() == $decoded['skillname'])
                    return http_response_code(409);

            $skillRepository->addUserSkill($user, $decoded['skillname']);

            return http_response_code(201);
        }
        else
            return http_response_code(400);
    }

    public function fetchDeleteSkill()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if (!$this->isDelete())
            return http_response_code(405);

        if ($contentType === "application/json")
        {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            if ((!isset($_SERVER["HTTP_SESSIONID"]))||(!isset($decoded['skillname'])))
                return http_response_code(401);

            $sessionid = $_SERVER["HTTP_SESSIONID"];

            if (!$this->verifySession($sessionid))
            {
                return http_response_code(401);
            }

            $userRepository = new UserRepository();
            $skillRepository = new SkillRepository();

            $user = $userRepository->getUserBySessionID($sessionid);
            $skillRepository->deleteUserSkill($user, $decoded['skillname']);

            return http_response_code(200);
        }
        else
            return http_response_code(400);
    }

    public function fetchGetSkill()
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
        $skillRepository = new SkillRepository();
        $user = $userRepository->getUserBySessionID($sessionid);

        $result = [];

        foreach ($skillRepository->getUserSkills($user) as $skill)
            $result[] = ['skillName' => $skill->getSkillName(), 'lastPracticed' => $skill->getLastPracticed()];

        header('Content-type: application/json');
        echo json_encode($result);
        return http_response_code(200);
    }
}
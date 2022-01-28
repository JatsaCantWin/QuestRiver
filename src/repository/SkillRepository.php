<?php

include_once "Repository.php";
require_once __DIR__.'/../models/Skill.php';

class SkillRepository extends Repository
{
    public function getUserSkills(User $user): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM "Users_Skills" INNER JOIN "Users" ON "Users"."User_ID" = "Users_Skills"."User_ID" WHERE "Email" = ?
        ');

        $stmt->execute([$user->getEmail()]);
        $skills = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($skills as $skill)
        {
            $result[] = new Skill(
                $skill['SkillName'],
                strtotime($skill['LastPracticed'])
            );
        }

        return $result;
    }

    public function addUserSkill(User $user, string $skillName): void
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO "Users_Skills" ("User_ID", "SkillName") SELECT "User_ID", ? FROM "Users" WHERE "Email" = ?;
        ');

        $stmt->execute([
            $skillName,
            $user->getEmail()
        ]);
    }

    public function deleteUserSkill(User $user, string $skillName): void
    {
        $stmt = $this->database->connect()->prepare('
            DELETE FROM "Users_Skills" USING "Users"
            WHERE
                  "Users_Skills"."User_ID" = "Users"."User_ID" AND
                  "Users"."Email" = ? AND
                  "SkillName" = ?
        ');

        $stmt->execute([
            $user->getEmail(),
            $skillName
        ]);
    }
}
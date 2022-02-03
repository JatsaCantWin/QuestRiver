<?php

include_once "Repository.php";
require_once __DIR__.'/../models/Quest.php';

class QuestRepository extends Repository
{
    public function getUserQuests(User $user): array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM "Users_Quests" INNER JOIN "Users" ON "Users"."User_ID" = "Users_Quests"."User_ID" WHERE "Email" = ?
        ');
        $stmt->execute([$user->getEmail()]);
        $quests = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($quests as $quest)
        {
            $result[] = new Quest(
                $quest['QuestName'],
                $quest['Finished']
            );
        }
        return $result;
    }

    public function addUserQuest(User $user, string $questName): void
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO "Users_Quests" ("User_ID", "QuestName") SELECT "User_ID", ? FROM "Users" WHERE "Email" = ?;
        ');

        $stmt->execute([
            $questName,
            $user->getEmail()
        ]);
    }

    public function deleteUserQuest(User $user, string $questName): void
    {
        $stmt = $this->database->connect()->prepare('
            DELETE FROM "Users_Quests" USING "Users"
            WHERE
                  "Users_Quests"."User_ID" = "Users"."User_ID" AND
                  "Users"."Email" = ? AND
                  "QuestName" = ?
        ');

        $stmt->execute([
            $user->getEmail(),
            $questName
        ]);
    }

    public function finishUserQuest(User $user, string $questName): void
    {
        $stmt = $this->database->connect()->prepare('
            CALL finishquest(?, ?)
        ');

        $stmt->execute([
            $questName,
            $user->getEmail()
        ]);
    }
}
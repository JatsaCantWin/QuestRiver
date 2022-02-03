<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{
    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM "Users" JOIN "Roles" ON "Roles"."Role_ID" = "Users"."Role_ID" WHERE "Email" = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STMT);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            return null;
        }

        return new User(
            $user['Email'],
            $user['Password'],
            $user['Username'],
            $user['RoleName']
        );
    }

    public function getUserStats(User $user): ?array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM "User_Stats" INNER JOIN "Users" ON "Users"."User_ID" = "User_Stats"."User_ID" WHERE "Email" = ?
        ');
        $stmt->execute([
            $user->getEmail()
        ]);

        $stats = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stats == false) {
            return null;
        }

        return [
            'strength' => $stats['Strength'],
            'dexterity' => $stats['Dexterity'],
            'constitution' => $stats['Constitution'],
            'intelligence' => $stats['Intelligence'],
            'wisdom' => $stats['Wisdom'],
            'charisma' => $stats['Charisma'],
            'health' => $stats['Health'],
            'magic' => $stats['Magic'],
            'stamina' => $stats['Stamina'],
            'xp' => $stats['XP'],
            'gold' => $stats['Gold'],
            'bills' => $stats['Bills'],
            'gems' => $stats['Gems'],
            'level' => $stats['Level'],
            'upgrades' => $stats['AttributeUpgrades']
        ];
    }

    public function addXP(User $user, int $amount): void
    {
        $stmt = $this->database->connect()->prepare('
            UPDATE "User_Stats" SET "XP" = "XP" + ? FROM "Users"
            WHERE "Users"."User_ID" = "User_Stats"."User_ID" AND
                  "Email" = ?;
        ');
        $stmt->execute([
            $amount,
            $user->getEmail()
        ]);
    }

    public function addUser(User $user): void
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO "Users" ("Email", "Password", "Username") 
            VALUES (?, ?, ?)
        ');

        $stmt->execute([
            $user->getEmail(),
            $user->getPassword(),
            $user->getUsername()
        ]);
    }

    public function getUserBySessionID(string $sessionID): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM "Users" CROSS JOIN getuserbysessionid(?) WHERE getuserbysessionid = "User_ID";
        ');
        $stmt->execute([
            $sessionID
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user === false)
            return null;

        return new User(
            $user['Email'],
            $user['Password'],
            $user['Username']
        );
    }

    public function advanceAttribute(User $user, string $attributeName)
    {
        $stmt = $this->database->connect()->prepare('
            CALL advAttribute(?, ?);
        ');
        $stmt->execute([
            $attributeName,
            $user->getEmail()
        ]);
    }

    public function isValidSession(string $sessionID): bool
    {
        return !(is_null($this->getUserBySessionID($sessionID)));
    }

    public function startSession(User $user): void
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM startsession(?)
        ');
        $stmt->execute([
            $user->getEmail()
        ]);

        $sessionID = $stmt->fetch(PDO::FETCH_ASSOC)['startsession'];
        setcookie("sessionid", $sessionID, time() + COOKIE_LIFETIME);
    }

    public function stopSession(string $sessionID): void
    {
        $stmt = $this->database->connect()->prepare('
            DELETE FROM "Sessions" WHERE "session_id" = ?
        ');
        $stmt->execute([
            $sessionID
        ]);
    }
}
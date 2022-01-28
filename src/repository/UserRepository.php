<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{
    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM "Users" WHERE "Email" = :email
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
            $user['Username']
        );
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
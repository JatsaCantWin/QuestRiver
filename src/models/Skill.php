<?php

class Skill
{
    private $skillName;
    private $lastPracticed;

    public function __construct(string $skillName, int $lastPracticed)
    {
        $this->skillName = $skillName;
        $this->lastPracticed = $lastPracticed;
    }

    public function getSkillName(): string
    {
        return $this->skillName;
    }

    public function setSkillName(string $skillName): void
    {
        $this->skillName = $skillName;
    }

    public function getLastPracticed(): int
    {
        return $this->lastPracticed;
    }

    public function practice(): void
    {
        $this->lastPracticed = time();
    }
}
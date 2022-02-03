<?php

class Quest
{
    private $questName;
    private $finished;

    public function __construct(string $questName, bool $finished)
    {
        $this->questName = $questName;
        $this->finished = $finished;
    }

    public function getQuestName(): string
    {
        return $this->questName;
    }

    public function setQuestName(string $questName): void
    {
        $this->questName = $questName;
    }

    public function isFinished(): bool
    {
        return $this->finished;
    }

    public function setFinished(bool $finished): void
    {
        $this->finished = $finished;
    }


}
<?php

declare(strict_types=1);

namespace Score\Entity;

class Game
{
    private int $homeScore;

    private int $awayScore;

    private bool $isEnded;

    public function __construct(private readonly Team $home, private readonly Team $away)
    {
        $this->homeScore = 0;
        $this->awayScore = 0;
        $this->isEnded = false;
    }

    public function getHome(): Team
    {
        return $this->home;
    }

    public function getAway(): Team
    {
        return $this->away;
    }

    public function getHomeScore(): int
    {
        return $this->homeScore;
    }

    public function getAwayScore(): int
    {
        return $this->awayScore;
    }

    public function isEnded(): bool
    {
        return $this->isEnded;
    }

    public function finishGame(): void
    {
        $this->isEnded = true;
    }

    public function updateScore(int $homeScore, int $awayScore): void
    {
        if ($this->homeScore > $homeScore) {
            throw new \InvalidArgumentException('Current score is greater than ' . $homeScore);
        }

        if ($this->awayScore > $awayScore) {
            throw new \InvalidArgumentException('Current score is greater than ' . $awayScore );
        }

        $this->homeScore = $homeScore;
        $this->awayScore = $awayScore;
    }

    public function getTotalScore(): int
    {
        return $this->homeScore + $this->awayScore;
    }
}

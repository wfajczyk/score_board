<?php

declare(strict_types=1);

namespace Score\Entity;

class Board
{
    /**
     * @var array<string,Game>
     */
    private array $games;

    public function __construct()
    {
        $this->games = [];
    }

    public function addGame(Game $game): void
    {
        $key = $this->getKey($game->getHome(), $game->getAway());
        if (!isset($this->games[$key])) {
            $this->games[$key] = $game;

            return;
        }
        if (!$this->games[$key]->isEnded()) {
            throw new \LogicException('This game is currently in progress');
        }

        $this->games[$key] = $game;
    }

    public function getGame(Team $home, Team $away): ?Game
    {
        return $this->games[$this->getKey($home, $away)] ?? null;
    }

    public function removeGame(Team $home, Team $away): void
    {
        unset($this->games[$this->getKey($home, $away)]);
    }

    /**
     * @return array<string,Game>
     */
    public function getGames(): array
    {
        return $this->games;
    }

    private function getKey(Team $home, Team $away): string
    {
        return strtolower($home->getName() . '_' . $away->getName());
    }
}

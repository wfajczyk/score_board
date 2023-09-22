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
        $key = strtolower($game->getHome()->getName() . '_' . $game->getAway()->getName());
        if (!isset($this->games[$key])) {
            $this->games[$key] = $game;

            return;
        }
        if (!$this->games[$key]->isEnded()) {
            throw new \LogicException('This game is currently in progress');
        }

        $this->games[$key] = $game;
    }

    /**
     * @return array<string,Game>
     */
    public function getGames(): array
    {
        return $this->games;
    }

}

<?php

declare(strict_types=1);

namespace Score\Service;

use Score\Entity\Board;
use Score\Entity\Game;
use Score\Entity\Team;

class ScoreBoard
{
    private Board $board;

    public function __construct()
    {
        $this->board = new Board();
    }

    public function addGame(Game $game): void
    {
        $this->board->addGame($game);
    }

    public function uploadScore(Team $home, Team $away, int $homeScore, int $awayScore): void
    {
        $this->getGame($home, $away)->updateScore($homeScore, $awayScore);
    }

    public function finishGame(Team $home, Team $away): void
    {
        $game = $this->getGame($home, $away);
        $game->finishGame();
        $this->board->removeGame($home, $away);
    }

    /**
     * @return array<Game>
     */
    public function getSummary(): array
    {
        $array = $this->board->getGames();
        usort($array, static function (Game $a, Game $b) {
            if ($b->getTotalScore() < $a->getTotalScore()) {
                return 1;
            }

            return 0;
        });

        return array_reverse($array);
    }

    private function getGame(Team $home, Team $away): Game
    {
        $game = $this->board->getGame($home, $away);
        if (null === $game) {
            throw new \LogicException('No found game ' . $home->getName() . ' - ' . $away->getName());
        }

        return $game;
    }
}

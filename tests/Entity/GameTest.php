<?php

declare(strict_types=1);

namespace Score\Tests\Entity;

use PHPUnit\Framework\TestCase;
use Score\Entity\Game;
use Score\Entity\Team;

class GameTest extends TestCase
{
    public function testCreation(): void
    {
        $teamHome = new Team('Mexico');
        $teamAway = new Team('Canada');
        $game = new Game($teamHome, $teamAway);

        self::assertEquals($teamHome, $game->getHome());
        self::assertEquals($teamAway, $game->getAway());
        self::assertEquals(0, $game->getHomeScore());
        self::assertEquals(0, $game->getAwayScore());
        self::assertFalse($game->isEnded());
    }

    public function testUpdate(): void
    {
        $teamHome = new Team('Mexico');
        $teamAway = new Team('Canada');
        $game = new Game($teamHome, $teamAway);

        self::assertEquals(0, $game->getHomeScore());
        self::assertEquals(0, $game->getAwayScore());

        $game->updateScore(0,5);

        self::assertEquals(0, $game->getHomeScore());
        self::assertEquals(5, $game->getAwayScore());
    }

    public function testUpdateInvalidHome(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $teamHome = new Team('Mexico');
        $teamAway = new Team('Canada');
        $game = new Game($teamHome, $teamAway);

        self::assertEquals(0, $game->getHomeScore());
        self::assertEquals(0, $game->getAwayScore());

        $game->updateScore(-1,-1);
    }

    public function testUpdateInvalidAway(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $teamHome = new Team('Mexico');
        $teamAway = new Team('Canada');
        $game = new Game($teamHome, $teamAway);

        self::assertEquals(0, $game->getHomeScore());
        self::assertEquals(0, $game->getAwayScore());

        $game->updateScore(1,-1);
    }

    public function testEnded(): void
    {
        $teamHome = new Team('Mexico');
        $teamAway = new Team('Canada');
        $game = new Game($teamHome, $teamAway);

        self::assertFalse($game->isEnded());

        $game->finishGame();

        self::assertTrue($game->isEnded());
    }
}

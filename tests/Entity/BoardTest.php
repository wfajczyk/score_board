<?php

declare(strict_types=1);

namespace Score\Tests\Entity;

use PHPUnit\Framework\TestCase;
use Score\Entity\Board;
use Score\Entity\Game;
use Score\Entity\Team;

class BoardTest extends TestCase
{
    public function testCreation(): void
    {
        $board = new Board();

        self::assertEmpty($board->getGames());
    }

    public function testAddGame(): void
    {
        $teamA = $this->createMock(Team::class);
        $teamA->expects(self::once())->method('getName')->willReturn('A');

        $teamB = $this->createMock(Team::class);
        $teamB->expects(self::once())->method('getName')->willReturn('b');

        $game = $this->createMock(Game::class);
        $game->expects(self::once())->method('getHome')->willReturn($teamA);
        $game->expects(self::once())->method('getAway')->willReturn($teamB);

        $board = new Board();
        $board->addGame($game);

        self::assertArrayHasKey('a_b', $board->getGames());
    }

    public function testAddDuplicateGame(): void
    {
        $this->expectException(\LogicException::class);

        $teamA = $this->createMock(Team::class);
        $teamA->expects(self::atMost(2))->method('getName')->willReturn('A');

        $teamB = $this->createMock(Team::class);
        $teamB->expects(self::atMost(2))->method('getName')->willReturn('b');

        $game = $this->createMock(Game::class);
        $game->expects(self::atMost(2))->method('getHome')->willReturn($teamA);
        $game->expects(self::atMost(2))->method('getAway')->willReturn($teamB);
        $game->expects(self::once())->method('isEnded')->willReturn(false);

        $board = new Board();
        $board->addGame($game);
        $board->addGame($game);
    }
}

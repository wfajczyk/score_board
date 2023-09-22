<?php

declare(strict_types=1);

namespace Score\Tests\Service;

use PHPUnit\Framework\TestCase;
use Score\Entity\Game;
use Score\Entity\Team;
use Score\Service\ScoreBoard;

class ScoreBoardTest extends TestCase
{
    private ScoreBoard $scoreBoard;

    protected function setUp(): void
    {
        parent::setUp();
        $this->scoreBoard = new ScoreBoard();
    }

    public function testAddGames(): void
    {
        $game = $this->createMock(Game::class);

        $this->scoreBoard->addGame($game);

        $array = $this->scoreBoard->getSummary();

        self::assertCount(1, $array);
    }

    public function testUploadScore(): void
    {
        $teamA = new Team('A');
        $teamB = new Team('B');

        $game = new Game($teamA, $teamB);


        $this->scoreBoard->addGame($game);
        $this->scoreBoard->uploadScore($teamA, $teamB, 2, 1);

        $array = $this->scoreBoard->getSummary();

        self::assertCount(1, $array);
        self::assertEquals(2, $array[0]->getHomeScore());
        self::assertEquals(1, $array[0]->getAwayScore());
    }

    public function testUploadScoreNoExistingGama(): void
    {
        $this->expectException(\LogicException::class);

        $teamA = new Team('A');
        $teamB = new Team('B');
        $teamC = new Team('C');

        $game = new Game($teamA, $teamB);


        $this->scoreBoard->addGame($game);
        $this->scoreBoard->uploadScore($teamA, $teamC, 2, 1);
    }

    public function testFinishGame(): void
    {
        $teamA = new Team('A');
        $teamB = new Team('B');

        $game = new Game($teamA, $teamB);


        $this->scoreBoard->addGame($game);
        self::assertCount(1, $this->scoreBoard->getSummary());

        $this->scoreBoard->finishGame($teamA, $teamB);
        self::assertCount(0, $this->scoreBoard->getSummary());
    }


    public function testSystem(): void
    {
        $scoreBoard = $this->scoreBoard;

        foreach ($this->getTestScore() as $game) {
            $scoreBoard->addGame(new Game($game['home'], $game['away']));
            $scoreBoard->uploadScore($game['home'], $game['away'], $game['homeScore'], $game['awayScore']);
        }

        $summary = $scoreBoard->getSummary();

        self::assertEquals('Uruguay', $summary[0]->getHome()->getName());
        self::assertEquals('Italy', $summary[0]->getAway()->getName());
        self::assertEquals(6, $summary[0]->getHomeScore());
        self::assertEquals(6, $summary[0]->getAwayScore());

        self::assertEquals('Spain', $summary[1]->getHome()->getName());
        self::assertEquals('Brazil', $summary[1]->getAway()->getName());
        self::assertEquals(10, $summary[1]->getHomeScore());
        self::assertEquals(2, $summary[1]->getAwayScore());

        self::assertEquals('Argentina', $summary[3]->getHome()->getName());
        self::assertEquals('Australia', $summary[3]->getAway()->getName());
        self::assertEquals(3, $summary[3]->getHomeScore());
        self::assertEquals(1, $summary[3]->getAwayScore());

        self::assertEquals('Germany', $summary[4]->getHome()->getName());
        self::assertEquals('France', $summary[4]->getAway()->getName());
        self::assertEquals(2, $summary[4]->getHomeScore());
        self::assertEquals(2, $summary[4]->getAwayScore());
    }

    /**
     * @return array<mixed>
     */
    private function getTestScore(): array
    {
        return [
            [
                'home' => new Team('Mexico'),
                'away' => new Team('Canada'),
                'homeScore' => 0,
                'awayScore' => 5,
            ],
            [
                'home' => new Team('Spain'),
                'away' => new Team('Brazil'),
                'homeScore' => 10,
                'awayScore' => 2,
            ],
            [
                'home' => new Team('Germany'),
                'away' => new Team('France'),
                'homeScore' => 2,
                'awayScore' => 2,
            ],
            [
                'home' => new Team('Uruguay'),
                'away' => new Team('Italy'),
                'homeScore' => 6,
                'awayScore' => 6,
            ],
            [
                'home' => new Team('Argentina'),
                'away' => new Team('Australia'),
                'homeScore' => 3,
                'awayScore' => 1,
            ],
        ];
    }
}

<?php

declare(strict_types=1);

namespace Score\Tests\Entity;

use PHPUnit\Framework\TestCase;
use Score\Entity\Team;

class TeamTest extends TestCase
{
    public function testCreation(): void
    {
        $team = new Team('Mexico');

        self::assertEquals('Mexico', $team->getName());
    }

    public function testCreationWithoutName(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new Team('');
    }

    public function testCreationValidation(): void
    {
        self::assertTrue(Team::isValid('a'));
        self::assertTrue(Team::isValid(str_repeat('a', 128)));

        self::assertFalse(Team::isValid(''));
        self::assertFalse(Team::isValid(str_repeat('a', 129)));
    }
}

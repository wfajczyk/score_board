<?php


declare(strict_types=1);

namespace Score\Entity;


class Team
{
    public const MIN_LENGTH = 1;
    public const MAX_LENGTH = 128;

    public function __construct(private readonly string $name)
    {
        if (!static::isValid($this->name)) {
            throw new \InvalidArgumentException('This value is not valid');
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public static function isValid(string $name): bool
    {
        return mb_strlen($name) <= self::MAX_LENGTH
            && mb_strlen($name) >= self::MIN_LENGTH;
    }
}

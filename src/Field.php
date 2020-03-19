<?php

/**
 * Поле шахматной доски
 *
 * Class Field
 */
class Field
{
    /** @var string */
    private $x;

    /** @var int */
    private $y;

    public function __construct(string $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function getX(): string
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

}

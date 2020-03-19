<?php

class Figure {

    /** @var bool  */
    protected $isBlack;

    public function __construct(bool $isBlack) {
        $this->isBlack = $isBlack;
    }

    public function isBlack(): bool
    {
        return $this->isBlack;
    }

    /** @noinspection PhpToStringReturnInspection */
    public function __toString() {
        throw new \Exception("Not implemented");
    }
}

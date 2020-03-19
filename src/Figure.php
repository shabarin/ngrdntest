<?php

class Figure {

    /** @var bool  */
    protected $isBlack;

    /** @var Field */
    protected $field;

    public function __construct(bool $isBlack, Field $field) {
        $this->isBlack = $isBlack;
        $this->field = $field;
    }

    public function isBlack(): bool
    {
        return $this->isBlack;
    }

    public function move(Field $to): void
    {
        $this->field = $to;
    }

    public function canMove(Field $to, Desk $desk): bool
    {
        // @todo сделать имплементацию для всех фигур, а здесь бросать исключение аналогично \Figure::__toString
        return true;
    }

    /** @noinspection PhpToStringReturnInspection */
    public function __toString() {
        throw new \Exception("Not implemented");
    }
}

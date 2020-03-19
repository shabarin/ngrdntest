<?php

class Pawn extends Figure
{

    /** @var bool */
    private $moved;

    public function __construct(bool $isBlack, Field $field)
    {
        parent::__construct($isBlack, $field);
        $this->moved = false;
    }

    public function __toString()
    {
        return $this->isBlack ? '♟' : '♙';
    }

    public function move(Field $to): void
    {
        parent::move($to);
        $this->moved = true;
    }

    public function canMove(Field $to, Desk $desk): bool
    {
        // Пешка может ходить вперёд (по вертикали) на одну клетку;
        if (
            $this->field->forward(1, $this->isBlack)->equals($to)
            && $desk->existsEmptyField($to)
        ) {
            return true;
        }

        // Если пешка ещё ни разу не ходила, она может пойти вперёд на две клетки;
        if (
            false === $this->moved
            && $this->field->forward(2, $this->isBlack)->equals($to)
            && $desk->existsEmptyField($this->field->forward(1, $this->isBlack))
            && $desk->existsEmptyField($this->field->forward(2, $this->isBlack))
        ) {
            return true;
        }

        // Пешка не может перепрыгивать через другие фигуры; — учли

        // Пешка может бить фигуры противника только по диагонали вперёд на одну клетку;
        if (
            $desk->existsEnemy(
                $this->field->forwardLeft(1, $this->isBlack),
                $this->isBlack
            )
            || $desk->existsEnemy(
                $this->field->forwardRight(1, $this->isBlack),
                $this->isBlack
            )
        ) {
            return true;
        }

        // Также существует взятие на проходе, но им можно пренебречь :) — пренебрегли :)

        return false;
    }

}

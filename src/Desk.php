<?php

class Desk
{

    private $figures = [];

    /** @var bool */
    private $isBlackMove;

    public function __construct()
    {
        $this->isBlackMove = false;

        $this->createFigure('a', 1, false, Rook::class);
        $this->createFigure('b', 1, false, Knight::class);
        $this->createFigure('c', 1, false, Bishop::class);
        $this->createFigure('d', 1, false, Queen::class);
        $this->createFigure('e', 1, false, King::class);
        $this->createFigure('f', 1, false, Bishop::class);
        $this->createFigure('g', 1, false, Knight::class);
        $this->createFigure('h', 1, false, Rook::class);

        $this->createFigure('a', 2, false, Pawn::class);
        $this->createFigure('b', 2, false, Pawn::class);
        $this->createFigure('c', 2, false, Pawn::class);
        $this->createFigure('d', 2, false, Pawn::class);
        $this->createFigure('e', 2, false, Pawn::class);
        $this->createFigure('f', 2, false, Pawn::class);
        $this->createFigure('g', 2, false, Pawn::class);
        $this->createFigure('h', 2, false, Pawn::class);

        $this->createFigure('a', 7, true, Pawn::class);
        $this->createFigure('b', 7, true, Pawn::class);
        $this->createFigure('c', 7, true, Pawn::class);
        $this->createFigure('d', 7, true, Pawn::class);
        $this->createFigure('e', 7, true, Pawn::class);
        $this->createFigure('f', 7, true, Pawn::class);
        $this->createFigure('g', 7, true, Pawn::class);
        $this->createFigure('h', 7, true, Pawn::class);

        $this->createFigure('a', 8, true, Rook::class);
        $this->createFigure('b', 8, true, Knight::class);
        $this->createFigure('c', 8, true, Bishop::class);
        $this->createFigure('d', 8, true, Queen::class);
        $this->createFigure('e', 8, true, King::class);
        $this->createFigure('f', 8, true, Bishop::class);
        $this->createFigure('g', 8, true, Knight::class);
        $this->createFigure('h', 8, true, Rook::class);
    }

    public function move($move)
    {
        if (!preg_match('/^([a-h])(\d)-([a-h])(\d)$/', $move, $match)) {
            throw new \Exception("Incorrect move");
        }

        $xFrom = $match[1];
        $yFrom = $match[2];
        $xTo = $match[3];
        $yTo = $match[4];

        $from = new Field($xFrom, $yFrom);
        $to = new Field($xTo, $yTo);

        $this->doMove($from, $to);
    }

    /**
     * @param Field $field
     * @return bool истина, если на переданном поле нет фигуры
     */
    public function existsEmptyField(Field $field): bool
    {
        return (null === $this->searchFigureAt($field));
    }

    /**
     * @param Field $field
     * @param bool $isBlack признак «своего» цвета
     * @return bool истина, если на переданном поле существует фигура противоположного цвета
     */
    public function existsEnemy(Field $field, bool $isBlack): bool
    {
        $figure = $this->searchFigureAt($field);
        if (!$figure) {
            return false;
        }

        return ($isBlack !== $figure->isBlack());
    }

    public function dump()
    {
        for ($y = 8; $y >= 1; $y--) {
            echo "$y ";
            for ($x = 'a'; $x <= 'h'; $x++) {
                if (isset($this->figures[$x][$y])) {
                    echo $this->figures[$x][$y];
                } else {
                    echo '-';
                }
            }
            echo "\n";
        }
        echo "  abcdefgh\n";
    }

    private function createFigure(string $x, int $y, bool $isBlack, string $figureClass): void
    {
        $this->figures[$x][$y] = new $figureClass($isBlack, new Field($x, $y));
    }

    private function doMove(Field $from, Field $to): void
    {
        $figure = $this->searchFigureAt($from);
        if (!$figure) {
            throw new \Exception('Invalid move.');
        }
        if ($figure->isBlack() !== $this->isBlackMove) {
            throw new \Exception('Invalid move (not your turn).');
        }
        if (!$figure->canMove($to, $this)) {
            throw new \Exception('Invalid move (figure cannot do this move).');
        }

        $this->isBlackMove = !$this->isBlackMove;
        $this->figures[$to->getX()][$to->getY()] = $figure;
        unset($this->figures[$from->getX()][$from->getY()]);
        $figure->move($to);
    }

    /**
     * Возвращает фигуру на заданном поле; или null в случае, если фигуры нет или поле невалидно
     */
    private function searchFigureAt(Field $field): ?Figure
    {
        if (!$field->isValid()) {
            return null;
        }
        if (!isset($this->figures[$field->getX()][$field->getY()])) {
            return null;
        }

        return $this->figures[$field->getX()][$field->getY()];
    }

}

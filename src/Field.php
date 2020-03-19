<?php

/**
 * Immutable
 *
 * Поле шахматной доски.
 * Знает об ограничениях 1-8 и a-h, знает о направлениях (вперед/назад, диагонали и т.д.)
 *
 * Class Field
 */
class Field
{
    /** @var string */
    private $x;

    /** @var int */
    private $y;

    /** @var bool признак того, что поле не существует на доске */
    private $isNull;

    public function __construct(string $x, int $y)
    {
        if ($x < 'a' || $x > 'h' || $y < 1 || $y > 8) {
            $this->isNull = true;

            return;
        }

        $this->isNull = false;
        $this->x = $x;
        $this->y = $y;
    }

    public function getX(): string
    {
        if ($this->isNull) {
            throw new LogicException('trying to get coords of invalid field');
        }

        return $this->x;
    }

    public function getY(): int
    {
        if ($this->isNull) {
            throw new LogicException('trying to get coords of invalid field');
        }

        return $this->y;
    }

    public function isValid(): bool
    {
        return !$this->isNull;
    }

    /**
     * Сравнивает текущее поле с переданным. Возвращает false в случае, если поля не равны или если одно из полей невалидно.
     *
     * @param Field $to
     * @return bool
     */
    public function equals(Field $to): bool
    {
        if ($this->isNull || $to->isNull) {
            return false;
        }

        return (
            $this->x === $to->x
            && $this->y === $to->y
        );
    }

    /**
     * Возвращает новое поле, отстоящее от текущего на заданные смещения stepX, stepY
     *
     * @param int $stepX
     * @param int $stepY
     * @return $this
     */
    public function adjust(int $stepX, int $stepY): self
    {
        $newY = $this->y + $stepY;
        $newX = chr(ord($this->x) + $stepX);

        return new self($newX, $newY);
    }

    /**
     * Возвращает поле, находящееся впереди на $step шагов с точки зрения черной или белой фигуры
     *
     * @param int $step
     * @param bool $blackPointOfView
     * @return $this
     */
    public function forward(int $step, bool $blackPointOfView): self
    {
        if ($blackPointOfView) {
            return $this->adjust(0, -$step);
        }

        return $this->adjust(0, $step);
    }

    /**
     * Возвращает поле, находящееся по диагонали впереди-слева на $step шагов с точки зрения черной или белой фигуры
     *
     * @param int $step
     * @param bool $blackPointOfView
     * @return $this
     */
    public function forwardLeft(int $step, bool $blackPointOfView): self
    {
        if ($blackPointOfView) {
            return $this->adjust($step, -$step);
        }

        return $this->adjust(-$step, $step);
    }

    /**
     * Возвращает поле, находящееся по диагонали впереди-справа на $step шагов с точки зрения черной или белой фигуры
     *
     * @param int $step
     * @param bool $blackPointOfView
     * @return $this
     */
    public function forwardRight(int $step, bool $blackPointOfView): self
    {
        if ($blackPointOfView) {
            return $this->adjust(-$step, -$step);
        }

        return $this->adjust($step, $step);
    }

}

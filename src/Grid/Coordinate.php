<?php

declare(strict_types = 1);

namespace Dratejinn\Grid;

class Coordinate {

    public function __construct(public readonly int $x, public readonly int $y) {
    }

    public function isEqual(Coordinate $coordinate) : bool {
        return $this->x === $coordinate->x && $this->y === $coordinate->y;
    }

    public function __toString() : string {
        return '(' . $this->x . ',' . $this->y . ')';
    }
}
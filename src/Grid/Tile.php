<?php

declare(strict_types = 1);

namespace Dratejinn\Grid;

use Dratejinn\Grid\Map\Column;
use Dratejinn\Grid\Map\Row;

class Tile {

    public function __construct(public readonly Row $row, public readonly Column $column) {

    }

    public function getAdjacent(Direction $direction) : ?static {
        $x = $this->column->xCoordinate;
        $y = $this->row->yCoordinate;
        switch ($direction) {
            case Direction::NORTH:
                --$y;
                break;
            case Direction::NORTHEAST:
                --$y;
                ++$x;
                break;
            case Direction::EAST:
                ++$x;
                break;
            case Direction::SOUTHEAST:
                ++$y;
                ++$x;
                break;
            case Direction::SOUTH:
                ++$y;
                break;
            case Direction::SOUTHWEST:
                ++$y;
                --$x;
                break;
            case Direction::WEST:
                --$x;
                break;
            case Direction::NORTHWEST:
                --$x;
                --$y;
                break;
            default:
                throw new \UnexpectedValueException('Unexpected direction: '. $direction->getType());
        }

        return $this->row->map->getTileAtCoordinate(new Coordinate($x, $y));
    }

    public function getCoordinate(): Coordinate {
        return new Coordinate($this->column->xCoordinate, $this->row->yCoordinate);
    }


}
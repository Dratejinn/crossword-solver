<?php

declare(strict_types = 1);

namespace Dratejinn\Grid\Map;

use Dratejinn\Grid\Map;
use Dratejinn\Grid\Tile;
use Traversable;

class Row implements \IteratorAggregate {

    /**
     * @var Tile[]
     */
    private $_tiles = [];

    public function __construct(public readonly Map $map, public readonly int $yCoordinate, private readonly int $_colCount) {

    }

    public function getTileAtPosition(int $position) : ?Tile {
        return $this->_tiles[$position] ?? NULL;
    }

    public function addTile(Tile $tile) : void {
        if (count($this->_tiles) === $this->_colCount) {
            throw new \LogicException('Unable to add tile. Already got ' . $this->_colCount . ' number of tiles!');
        }
        $this->_tiles[] = $tile;
    }

    public function getIterator(): Traversable {
        return new \ArrayIterator($this->_tiles);
    }


}
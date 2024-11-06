<?php

declare(strict_types = 1);

namespace Dratejinn\Grid;

use Dratejinn\Grid\Map\Column;
use Dratejinn\Grid\Map\Row;

class Map {

    /**
     * @var Row[]
     */
    private $_rows = [];

    /**
     * @var Column[]
     */
    private $_columns = [];

    public function __construct(int $colCount, int $rowCount) {
        for ($i = 0; $i < $colCount; ++$i) {
            $this->_columns[] = $this->_createColumn($i, $rowCount);
        }

        for ($i = 0; $i < $rowCount; ++$i) {
            $this->_rows[] = $this->_createRow($i, $colCount);
        }
    }

    public function getTileAtCoordinate(Coordinate $coordinate): ?Tile {
        if (!isset($this->_rows[$coordinate->y])) {
            return NULL;
        }
        $row = $this->_rows[$coordinate->y];
        return $row->getTileAtPosition($coordinate->x);
    }

    public function getRowAtPosition(int $pos) : ?Row {
        return $this->_rows[$pos] ?? NULL;
    }

    public function getColumnAtPosition(int $pos) : ?Column {
        return $this->_columns[$pos] ?? NULL;
    }

    private function _createRow(int $yPos, int $colCount) : Row {
        return new Row($this, $yPos, $colCount);
    }

    private function _createColumn(int $xPos, int $rowCount) : Column {
        return new Column($this, $xPos, $rowCount);
    }

    public function getRowIterator() : \Iterator {
        return new \ArrayIterator($this->_rows);
    }

    public function getColumnIterator() : \Iterator {
        return new \ArrayIterator($this->_columns);
    }

    public function getRowCount() : int {
        return count($this->_rows);
    }

    public function getColumnCount() : int {
        return count($this->_columns);
    }
}
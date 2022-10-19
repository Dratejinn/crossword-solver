<?php

declare(strict_types = 1);

namespace Dratejinn\Crossword;

use Dratejinn\Grid\Map;

class Puzzle extends Map {

    public static function CreateFromArray(array $puzzle) : self {
        $colCount = NULL;
        $rowCount = count($puzzle);
        foreach ($puzzle as $index => $row) {
            if (!is_int($index)) {
                throw new \UnexpectedValueException('index needs to be an integer!');
            }
            if (!is_string($row)) {
                throw new \UnexpectedValueException('Row is not a string!');
            }
            if ($colCount === NULL) {
                $colCount = strlen($row);
            } else {
                if ($colCount !== strlen($row)) {
                    throw new \UnexpectedValueException('Row length is not equal! Expected: '. $colCount . ' got ' . strlen($row));
                }
            }
        }
        $self = new self($colCount, $rowCount);
        foreach ($puzzle as $rowIndex => $rowString) {
            $row = $self->getRowAtPosition($rowIndex);
            if ($row === NULL) {
                throw new \LogicException('Unable to retrieve row at position: ' . (string) $rowIndex);
            }
            foreach (str_split($rowString) as $colIndex => $letter) {
                $column = $self->getColumnAtPosition($colIndex);
                $letterObj = new Letter($row, $column);
                $letterObj->setLetter($letter);
                $row->addTile($letterObj);
                $column->addTile($letterObj);
            }
        }
        return $self;
    }

    public function clear() : void {
        /** @var Map\Row $row */
        foreach ($this->getRowIterator() as $row) {
            /** @var Letter $letter */
            foreach ($row as $letter) {
                $letter->clearSearchedDirections();
            }
        }
    }
}
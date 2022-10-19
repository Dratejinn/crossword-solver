<?php

declare(strict_types=1);

namespace Dratejinn\Crossword;

use Dratejinn\Grid\Direction;
use Dratejinn\Grid\Tile;

class Letter extends Tile {

    private $_letter = NULL;

    private $_searchedDirections = [];

    public function setLetter(string $letter) : void {
        if (strlen($letter) !== 1) {
            throw new \UnexpectedValueException('provided more than one letter!');
        }
        $this->_letter = $letter;
    }

    public function getLetter() : string {
        if ($this->_letter === NULL) {
            throw new \LogicException('Letter has not been set yet! Call setLetter first!');
        }
        return $this->_letter;
    }

    public function addSearchedDirection(Direction $direction) : void {
        $this->_searchedDirections[] = $direction;
    }

    public function isDirectionSearched(Direction $direction) : bool {
        return in_array($direction, $this->_searchedDirections);
    }

    public function clearSearchedDirections() : void {
        $this->_searchedDirections = [];
    }
}
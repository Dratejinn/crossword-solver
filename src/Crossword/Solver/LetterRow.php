<?php

declare(strict_types = 1);

namespace Dratejinn\Crossword\Solver;

use Dratejinn\Crossword\Letter;
use Dratejinn\Grid\Direction;

class LetterRow {

    /**
     * @var Letter[]
     */
    private array $_letters = [];

    private string $_string;

    private string $_revsersedString;

    public function __construct(array $letters, Direction $direction) {
        $letterArr = [];
        foreach ($letters as $letter) {
            if (!$letter instanceof Letter) {
                throw new \UnexpectedValueException('Entry in letters is not an instance of ' . Letter::class);
            }
            $this->_letters[] = $letter;
            $letterArr[] = $letter->getLetter();
            $letter->addSearchedDirection($direction);
        }
        $this->_string = implode('', $letterArr);
        $this->_revsersedString = implode('', array_reverse($letterArr));
    }

    /**
     * @return Letter[]
     */
    public function getLetters() : array {
        return $this->_letters;
    }

    public function getString() : string {
        return $this->_string;
    }

    public function getReversedString() : string {
        return $this->_revsersedString;
    }

    public function __toString() : string {
        return $this->getString();
    }
}
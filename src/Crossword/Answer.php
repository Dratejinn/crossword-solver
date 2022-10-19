<?php

declare(strict_types = 1);

namespace Dratejinn\Crossword;

use Dratejinn\Grid\Coordinate;

class Answer {

    public function __construct(public readonly Question $question, public readonly Coordinate $startCoordinate, public readonly Coordinate $endCoordinate) {
    }

    public function isSame(Answer $answer) : bool {
        if ($this->question->label === $answer->question->label) {
            return ($this->startCoordinate->isEqual($answer->startCoordinate) && $this->endCoordinate->isEqual($answer->endCoordinate)) || ($this->startCoordinate->isEqual($answer->endCoordinate) && $this->endCoordinate->isEqual($answer->startCoordinate));
        }
        return FALSE;
    }
}
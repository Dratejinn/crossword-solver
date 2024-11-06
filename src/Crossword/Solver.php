<?php

declare(strict_types = 1);

namespace Dratejinn\Crossword;

use Dratejinn\Crossword\Puzzle\Result;
use Dratejinn\Crossword\Solver\LetterRow;
use Dratejinn\Grid\Direction;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class Solver implements LoggerAwareInterface {

    private ?LoggerInterface $_logger = NULL;

    /**
     * @var Question[]
     */
    private $_questions = [];

    /**
     * @var Answer[]
     */
    private $_answers = [];

    public function __construct(array $questions) {
        foreach ($questions as $question) {
            if (!$question instanceof Question) {
                throw new \UnexpectedValueException('Unexpected answer provided!');
            }
            $this->_questions[] = $question;
        }
    }

    public function setLogger(LoggerInterface $logger): void {
        $this->_logger = $logger;
    }


    public function solvePuzzle(Puzzle $puzzle) : Result {
        $this->_answers = [];
        $puzzle->clear();

        $firstRow = $puzzle->getRowAtPosition(0);
        $firstColumn = $puzzle->getColumnAtPosition(0);
        $lastRow = $puzzle->getRowAtPosition($puzzle->getRowCount() -1);

        $unansweredQuestions = $this->_questions;

        foreach ($firstRow as $letter) {
            $this->_processLetter($letter, $unansweredQuestions);
            if (empty($unansweredQuestions)) {
                break;
            }
        }

        foreach ($firstColumn as $letter) {
            $this->_processLetter($letter, $unansweredQuestions);
            if (empty($unansweredQuestions)) {
                break;
            }
        }

        foreach ($lastRow as $letter) {
            $this->_processLetter($letter, $unansweredQuestions);
            if (empty($unansweredQuestions)) {
                break;
            }
        }

        return new Result($puzzle, $this->_questions, $this->_answers);
    }

    private function _processLetter(Letter $letter, array &$unansweredQuestions) : void {
        $scanDirections = [Direction::NORTHEAST, Direction::EAST, Direction::SOUTHEAST, Direction::SOUTH];

        foreach ($scanDirections as $scanDirection) {
            if (!$letter->isDirectionSearched($scanDirection)) {
                $letterRow = $this->_getLetterRow($letter, $scanDirection);
                $this->_findAnswersInLetterRow($letterRow, $unansweredQuestions);
            }
        }
    }

    private function _getLetterRow(Letter $letter, Direction $direction) : LetterRow {
        $arr = [];
        do {
            $arr[] = $letter;
            $letter = $letter->getAdjacent($direction);
        } while ($letter !== NULL);

        return new LetterRow($arr, $direction);
    }

    /**
     * @param LetterRow $letterRow
     * @param Question[] $unansweredQuestions
     */
    private function _findAnswersInLetterRow(LetterRow $letterRow, array &$unansweredQuestions) : void {
        $this->_findAnswersInString($letterRow->getLetters(), $letterRow->getString(), $unansweredQuestions);
        $this->_findAnswersInString(array_reverse($letterRow->getLetters()), $letterRow->getReversedString(), $unansweredQuestions);
    }

    /**
     * @param LetterRow $letterRow
     * @param string $string
     * @param Question[] $unansweredQuestions
     */
    private function _findAnswersInString(array $letters, string $string, array &$unansweredQuestions) : void {
        $this->_logger?->log(LogLevel::DEBUG, 'got ' . count ($unansweredQuestions) . ' Unanswered questions left');

        foreach ($unansweredQuestions as $index => $unansweredQuestion) {
            $startPos = strpos($string, $unansweredQuestion->label);
            if ($startPos !== FALSE) {
                $startLetter = $letters[$startPos];
                $lastLetter = $letters[($startPos + strlen($unansweredQuestion->label) -1)];

                $newAnswer = new Answer($unansweredQuestion, $startLetter->getCoordinate(), $lastLetter->getCoordinate());
                if (!$this->_isAlreadyAnswered($newAnswer)) {
                    $this->_answers[] = $newAnswer;
                    unset($unansweredQuestions[$index]);
                }
            }
        }
    }

    private function _isAlreadyAnswered(Answer $newAnswer) : bool {
        foreach ($this->_answers as $answer) {
            if ($answer->isSame($newAnswer)) {
                return TRUE;
            }
        }
        return FALSE;
    }
}
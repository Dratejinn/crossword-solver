<?php

declare(strict_types = 1);

namespace Dratejinn\Crossword\Puzzle;

use Dratejinn\Crossword\Answer;
use Dratejinn\Crossword\Puzzle;
use Dratejinn\Crossword\Question;

class Result {

    /**
     * @var Question[]
     */
    private array $_questions;

    /**
     * @var Answer[]
     */
    private array $_answers;

    public function __construct(public readonly Puzzle $puzzle, array $questions, array $answers) {
        foreach ($questions as $question) {
            if (!$question instanceof Question) {
                throw new \UnexpectedValueException('Value in array questions is expected to be an instance of ' . Question::class);
            }
            $this->_questions[] = $question;
        }
        foreach ($answers as $answer) {
            if (!$answer instanceof Answer) {
                throw new \UnexpectedValueException('Value in array questions is expected to be an instance of ' . Answer::class);
            }
            $this->_answers[] = $answer;
        }
    }

    public function isSolved() : bool {
        return count($this->_questions) === count($this->_answers);
    }

    /**
     * @return Answer[]
     */
    public function getAnswers() : array {
        return $this->_answers;
    }
}
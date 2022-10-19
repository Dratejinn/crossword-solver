<?php

declare(strict_types = 1);

namespace Dratejinn\Crossword;

class Question {

    public function __construct(public readonly string $label) {
    }
}
<?php

declare(strict_types = 1);

require __DIR__ . '/vendor/autoload.php';

$puzzle = [
    'NBABANNAANBAB',
    'ANABAABNAANAB',
    'NANAABBABBNBA',
    'BABANAANBABNB',
    'ANNBBNBBABANA',
    'BABABAANNANBB',
    'NBNAAANBANAAN',
    'BAABNNBAABNBB',
    'ANANAAABNANBA',
    'NNBBABABABAAB',
    'ABABNBNNBNANB',
    'BNAANABBNBNBN',
    'BBBNNABAABAAB',
    'NABANAANBABNA',
    'ABBABNBBNNBBB',
    'AABNNABABANAB',
    'NANAABAABBNBB',
    'ANABANAANAABA',
    'BANBABNBBANBN',
    'BABBAANAANABA',
    'ANNNNAANBANNA',
    'BANABBNAANABN',
    'NBABANBBABBAB',
    'BABABNAANABAN'
];

$handler = new \Monolog\Handler\StreamHandler(STDOUT);
$logger = new \Monolog\Logger('Solver', [$handler]);

$format = "%datetime% | %level_name% | %message%\n";
$formatter = new \Monolog\Formatter\LineFormatter($format, ignoreEmptyContextAndExtra: TRUE);
$handler->setFormatter($formatter);

$puzzleObj = \Dratejinn\Crossword\Puzzle::CreateFromArray($puzzle);

$questions = array_fill(0, 26, new \Dratejinn\Crossword\Question('BANAAN'));

$solver = new \Dratejinn\Crossword\Solver($questions);
$solver->setLogger($logger);
$result = $solver->solvePuzzle($puzzleObj);

var_dump($result->isSolved());

foreach ($result->getAnswers() as $answer) {
    $logger->log(\Psr\Log\LogLevel::DEBUG, $answer->startCoordinate . "\t" . $answer->endCoordinate);
}
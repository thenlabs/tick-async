<?php
declare(ticks=1);

require __DIR__.'/../vendor/autoload.php';

use function ThenLabs\TickAsync\async;

$callable = function () {
    for ($i = 1; $i <= 2; $i++) {
        echo "async: {$i}\n";
        yield;
    }

    return;
};

$task = async($callable, false);

for ($i = 1; $i <= 3; $i++) {
    echo "main: {$i}\n";
}

$task->register();
$task->await();

for ($i = 4; $i <= 7; $i++) {
    echo "main: {$i}\n";
}

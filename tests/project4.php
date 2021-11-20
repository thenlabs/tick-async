<?php
declare(ticks=1);

require __DIR__.'/../vendor/autoload.php';

use function ThenLabs\TickAsync\async;
use function ThenLabs\TickAsync\await;

$counter = 0;

$callable = function ($task) use (&$counter) {
    $counter++;

    echo "async: {$counter}\n";

    if ($counter >= 2) {
        $task->end('end');
    }
};

$task = async($callable, false);

for ($i = 1; $i <= 3; $i++) {
    echo "main: {$i}\n";
}

$task->register();
echo await($task)."\n";

for ($i = 4; $i <= 7; $i++) {
    echo "main: {$i}\n";
}

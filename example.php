<?php
declare(ticks=1);

require __DIR__.'/vendor/autoload.php';

use function ThenLabs\TickAsync\async;
use function ThenLabs\TickAsync\delay;

function printLog(string $msg)
{
    echo date('Y-m-d H:i:s')." ".$msg;
}

async(function ($task) {
    for ($i = 1; $i <= 15; $i++) {
        printLog("async1: {$i}\n");
        $task->addDelay('+1 seconds');
        yield;
    }

    return;
});

async(function ($task) {
    for ($i = 1; $i <= 10; $i++) {
        printLog("async2: {$i}\n");
        $task->addDelay('+2 seconds');
        yield;
    }

    return;
});

for ($i = 1; $i <= 5; $i++) {
    printLog("main: {$i}\n");
    delay('+500000 microseconds');
}

echo "bye\n";
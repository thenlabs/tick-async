<?php
declare(ticks=1);

require __DIR__.'/../vendor/autoload.php';

use function ThenLabs\TickAsync\async;
use function ThenLabs\TickAsync\suspendTicks;

async(function () {
    for ($i = 1; $i <= 5; $i++) {
        echo "async: {$i}\n";
        yield;
    }

    return;
});

suspendTicks();
for ($i = 1; $i <= 3; $i++) {
    echo "main: {$i}\n";
}

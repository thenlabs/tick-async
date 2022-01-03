<?php
declare(ticks=1);

require __DIR__.'/../vendor/autoload.php';

use function ThenLabs\TickAsync\async;
use function ThenLabs\TickAsync\suspendTicks;
use function ThenLabs\TickAsync\resumeTicks;

async(function () {
    for ($i = 1; $i <= 10; $i++) {
        echo "async: {$i}\n";
        yield;
    }

    return;
});

for ($i = 1; $i <= 10; $i++) {
    echo "main: {$i}\n";

    if ($i == 4) {
        suspendTicks();
    } elseif ($i == 8) {
        resumeTicks();
    }
}

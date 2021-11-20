<?php
declare(ticks=1);

require __DIR__.'/../vendor/autoload.php';

use function ThenLabs\TickAsync\async;

async(function () {
    for ($i = 1; $i <= 7; $i++) {
        echo "async1: {$i}\n";
        yield;
    }

    return;
});

async(function () {
    for ($i = 1; $i <= 5; $i++) {
        echo "async2: {$i}\n";
        yield;
    }

    return;
});

for ($i = 1; $i <= 3; $i++) {
    echo "main: {$i}\n";
}

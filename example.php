<?php
declare(ticks=1);

require __DIR__.'/vendor/autoload.php';

use function ThenLabs\TickAsync\async;

async(function () {
    for ($i = 1; $i <= 15; $i++) {
        echo "async: {$i}\n";
        yield;
    }

    return;
});

for ($i = 1; $i <= 5; $i++) {
    echo "main: {$i}\n";
}

echo "bye\n";
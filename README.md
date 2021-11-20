
# TickAsync

Asynchronous tasks based on ticks.

>If you like this project gift us a ⭐.

## Installation.

    $ composer require thenlabs/tick-task dev-master

## Usage.

TODO

## Example:

```php
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
```

Result:

```
async: 1
main: 1
async: 2
main: 2
async: 3
main: 3
async: 4
main: 4
async: 5
main: 5
async: 6
async: 7
bye
async: 8
async: 9
async: 10
async: 11
async: 12
async: 13
async: 14
async: 15
```
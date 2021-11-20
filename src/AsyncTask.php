<?php
declare(strict_types=1);

namespace ThenLabs\TickAsync;

use ThenLabs\TaskLoop\Task;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class AsyncTask extends Task
{
    public function register(): void
    {
        TickAsync::registerTask($this);
    }

    public function unregister(): void
    {
        TickAsync::unregisterTask($this);
    }

    public function await()
    {
        if (! $this->started) {
            return;
        }

        TickAsync::unregisterTickFunction();

        while (! $this->ended) {
            $this->run();
        }

        $this->unregister();

        TickAsync::registerTickFunction();

        return $this->result;
    }
}
